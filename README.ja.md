# Koriym.CsvEntities

## PDO - Fetching one to many related tables together


下記のようにTodoが複数のMemoを持つone-to-manyのエンティティリストをPDOで作成します。

### 例

```sql
SELECT todo.id AS id,
       todo.title AS title,
       memo.id AS memo_id,
       memo.body AS memo_body
FROM todo
       LEFT OUTER JOIN memo
       ON memo.todo_id = todo.id
GROUP BY todo.id;
```

Memoクラス
```php
final class Memo
{
    public string $id,
    public string $title
}
```

Todoクラス
```php
final class Todo
{
    public string $id,
    public string $title,
    /** @var array<Memo> */
    public array $memos,
}
```

## 使い方

上記のSQLとエンティティクラスを下記のように変更します。

```sql
SELECT todo.id AS id,
       todo.title AS title,
       GROUP_CONCAT(memo.id),
       GROUP_CONCAT(memo.body)
FROM todo
       LEFT OUTER JOIN memo
       ON memo.todo_id = todo.id
GROUP BY todo.id;
```


```php
final class Memo
{
    public function __construct(
        public string $id,
        public string $title
    ){}
}
```

```php
final class Todo
{
    /** @var array<Memo> */
    public array $memos;

    public function __construct(
        public string $id,
        public string $title,
        string|null $memoIds,
        string|null $memoBodies
    ){
        $this->memos = (new CsvEntities())(Memo::class, $memoIds, $memoBodies);
    }
}
````

SQLを`query()`した後に、下記のようにfetchAllします。
```php
$todoList = $pdo->fetchAll(PDO::FETCH_FUNC, static function (...$args) {
    return new Todo(...$args);
});
```
`
当初目的としたTodo[]配列が得られます。

```php
final class Todo
{
    public string $id,
    public string $title,
    /** @var array<Memo> */
    public array $memos,
}
```

## インストール

```
composer require koriym/csv-entities
```
