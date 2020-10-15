generate model:

**WARNING**: for user model add 

--base-class-name=Illuminate\\Foundation\\Auth\\User

<blockquote>
    artisan krlove:generate:model [ModelName]BaseModel --table-name=[TableName] --output-path=/var/www/app/Models/Generated/ --namespace=App\\Models\\Generated 
</blockquote>


generate repository:
<blockquote>
    artisan make:repository Repositories/[ModelName]Repository
</blockquote>
