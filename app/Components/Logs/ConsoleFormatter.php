<?php

namespace App\Components\Logs;

use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use Bramus\Ansi\Writers\BufferWriter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Monolog\Formatter\NormalizerFormatter;
use \Bramus\Ansi\Ansi;

/**
 * Class ConsoleFormatter
 *
 * @package App\Components\Logs
 */
class ConsoleFormatter extends NormalizerFormatter
{
    private Ansi $ansi;

    private array $styleLevelMapping = [
        'DEBUG' => ['38;5;40'],
        'INFO' => ['38;5;40'],
        'NOTICE' => ['38;5;11'],
        'WARNING' => ['38;5;11'],
        'ERROR' => ['38;5;160'],
        'CRITICAL' => ['38;5;160'],
        'ALERT' => ['38;5;160'],
        'EMERGENCY' => ['38;5;160'],
    ];

    private array $styleCommonMapping = [
        'data_type' => ['38;5;231'],
        'array_key' => ['38;5;14'],
    ];

    /**
     * ConsoleFormatter constructor.
     */
    public function __construct()
    {
        $this->ansi = new Ansi(new BufferWriter());

        parent::__construct();
    }

    /**
     * @param array $record
     *
     * @return array|mixed|string
     *
     * @throws \Exception
     */
    public function format(array $record)
    {
        $record = $this->normalize($record);
        $this->ansi->bold();

        $this->compileMessage($record);

        $consoleWidth = exec('tput cols') ?: 1;

        $this->ansi
            ->color('38;5;255')
            ->text(str_pad('', $consoleWidth, '#'))
            ->lf();

        return $this->ansi->get();
    }

    /**
     * @param array $records
     *
     * @return array|mixed|void
     */
    public function formatBatch(array $records)
    {
        dd('formatBatch');
    }

    /**
     * @param array $record
     *
     * @throws \Exception
     */
    private function compileMessage(array $record): void
    {
        $this->ansi->color($this->styleLevelMapping[$record['level_name']])->sgr(SGR::STYLE_INTENSITY_BRIGHT);
        $this->compileHeader($record);

        foreach ($record['context'] as $context) {
            $this->compileContext($record, $context);
        }
    }

    /**
     * @param array $record
     */
    private function compileHeader(array $record): void
    {
        $this->ansi->text('[ ')
            ->text($record['datetime'])
            ->text(' ] ')
            ->text($record['level_name'])
            ->text(' @ ')
            ->text($record['channel'])
            ->text(' : ')
            ->text($record['message'])
            ->lf();
    }

    /**
     * @param array $record
     * @param       $context
     *
     * @throws \Exception
     */
    private function compileContext(array $record, $context): void
    {
        $levelName = $record['level_name'];
        $this->compileValue($levelName, $context);

        $this->ansi->lf();
    }

    /**
     * @param     $levelName
     * @param     $value
     * @param int $depth
     *
     * @throws \Exception
     */
    private function compileValue($levelName, $value, $depth = 0): void
    {
        $type = gettype($value);

        if ($this->isScalar($value)) {
            $this->scalarToAnsi($levelName, $type, $value, $depth);
        } elseif ($this->isArray($value)) {
            $this->arrayToAnsi($levelName, 'array', $value, $depth);
        } elseif ($this->isModel($value)) {
            $namespace = explode('\\', get_class($value));
            $type = $namespace[count($namespace) - 1];

            $this->arrayToAnsi($levelName, $type, $value->getAttributes(), $depth);
        } elseif ($this->isException($value)) {
            $namespace = explode('\\', get_class($value));
            $type = $namespace[count($namespace) - 1];

            $newValue = [
                'class' => get_class($value),
                'message' => $value->getMessage(),
                'code' => $value->getCode(),
                'file' => $value->getFile() . ':' . $value->getLine(),
            ];

            $trace = $value->getTrace();
            foreach ($trace as $frame) {
                if (isset($frame['file'])) {
                    $newValue['trace'][] = $frame['file'].':'.$frame['line'];
                } elseif (isset($frame['function']) && $frame['function'] === '{closure}') {
                    // Simplify closures handling
                    $newValue['trace'][] = $frame['function'];
                } else {
                    if (isset($frame['args'])) {
                        // Make sure that objects present as arguments are not serialized nicely but rather only
                        // as a class name to avoid any unexpected leak of sensitive information
                        $frame['args'] = array_map(function ($arg) {
                            if (is_object($arg) && !($arg instanceof \DateTime || $arg instanceof \DateTimeInterface)) {
                                return sprintf("[object] (%s)", get_class($arg));
                            }

                            return $arg;
                        }, $frame['args']);
                    }
                    // We should again normalize the frames, because it might contain invalid items
                    $newValue['trace'][] = $this->toJson($this->normalize($frame), true);
                }
            }

            $this->arrayToAnsi($levelName, $type, $newValue, $depth);
        } else {
            throw new \Exception(sprintf('Unknown type: %s for writing to log', $type));
        }
    }

    /**
     * @param string $levelName
     * @param string $type
     * @param        $value
     * @param int    $depth
     */
    private function scalarToAnsi(string $levelName, string $type, $value, int $depth = 0): void
    {
        $this->compileContextHeader($this->getTypeText($type), $levelName, $depth);

        if ($type === 'boolean') {
            $value = $value ? 'true' : 'false';
        }

        if ($type === 'string') {
            $value = sprintf('\'%s\'', $value);
        }

        $this->ansi->text($value);
    }

    /**
     * @param string $levelName
     * @param string $type
     * @param        $key
     * @param        $value
     * @param int    $depth
     */
    private function arrayElementToAnsi(string $levelName, string $type, $key, $value, int $depth = 0): void
    {
        for ($i = 0; $i < $depth; $i++) {
            $this->ansi->tab();
        }

        $this->ansi->text('[')
            ->color($this->styleCommonMapping['array_key'])->text($key)
            ->color($this->styleLevelMapping[$levelName])->text('] => ');

        $this->scalarToAnsi($levelName, $type, $value);
    }

    /**
     * @param string $levelName
     * @param string $type
     * @param array  $array
     * @param int    $depth
     *
     * @throws \Exception
     */
    private function arrayToAnsi(string $levelName, string $type, array $array, int $depth = 0): void
    {
        $this->compileContextHeader($this->getTypeText($type), $levelName);
        $this->ansi->text('= [');
        $this->ansi->lf();

        foreach ($array as $key => $value) {
            if ($this->isScalar($value)) {
                $this->arrayElementToAnsi($levelName, gettype($value), $key, $value, $depth + 1);
                $this->ansi->lf();
            } else {
                for ($i = 0; $i < $depth; $i++) {
                    $this->ansi->tab();
                }
                $this->ansi->tab();

                $this->ansi->text('[')
                    ->color($this->styleCommonMapping['array_key'])->text($key)
                    ->color($this->styleLevelMapping[$levelName])->text('] => ');

                $this->compileValue($levelName, $value, $depth + 1);
                $this->ansi->lf();
            }
        }

        for ($i = 0; $i < $depth; $i++) {
            $this->ansi->tab();
        }

        $this->ansi->text(']');
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isScalar($value): bool
    {
        return in_array(gettype($value), ['integer', 'string', 'double', 'float', 'boolean', 'NULL']);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isArray($value): bool
    {
        return in_array(gettype($value), ['array']);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isModel($value): bool
    {
        return $value instanceof Model;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isException($value): bool
    {
        return $value instanceof \Exception || (PHP_VERSION_ID > 70000 && $value instanceof \Throwable);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function getTypeText(string $type): string
    {
        return $type;
    }

    /**
     * @param string $typeText
     * @param string $levelName
     * @param int    $depth
     */
    private function compileContextHeader(string $typeText, string $levelName, $depth = 0): void
    {
        for ($i = 0; $i < $depth; $i++) {
            $this->ansi->tab();
        }

        $this->ansi
            ->text('(')
            ->color($this->styleCommonMapping['data_type'])->text($typeText)
            ->color($this->styleLevelMapping[$levelName])->text(') ');
    }

    /**
     * @param     $data
     * @param int $depth
     *
     * @return array|Model|mixed|string
     */
    protected function normalize($data, $depth = 0)
    {
        if ($depth > 9) {
            return 'Over 9 levels deep, aborting normalization';
        }

        if (null === $data || is_scalar($data)) {
            if (is_float($data)) {
                if (is_infinite($data)) {
                    return ($data > 0 ? '' : '-') . 'INF';
                }
                if (is_nan($data)) {
                    return 'NaN';
                }
            }

            return $data;
        }

        if (is_array($data)) {
            $normalized = [];

            $count = 1;
            foreach ($data as $key => $value) {
                if ($count++ > 1000) {
                    $normalized['...'] = 'Over 1000 items ('.count($data).' total), aborting normalization';
                    break;
                }

                $normalized[$key] = $this->normalize($value, $depth+1);
            }

            return $normalized;
        }

        if ($data instanceof \DateTime || $data instanceof Carbon) {
            return $data->format($this->dateFormat);
        }

        if (is_object($data)) {

            if ($this->isException($data)) {
                return $data;
            }

            if ($data instanceof Model) {
                $value = $data;
            } elseif (method_exists($data, '__toString') && !$data instanceof \JsonSerializable) {
                $value = $data->__toString();
            } else {
                $value = $this->toJson($data, true);
            }

            return $value;
        }

        if (is_resource($data)) {
            return sprintf('[resource] (%s)', get_resource_type($data));
        }

        return '[unknown('.gettype($data).')]';
    }
}
