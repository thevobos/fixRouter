# fix-router

## METHOD

GET | POST | PUT | DELETE | HEAD | OPTIONS | PATCH

```php
Router::controller("/test/[:all]", new \App\www\controller\Test(),"app");
```
```
Router::get("/home/dashboard",function (){

    echo "hello world!";

});
```
```php
Router::get("/news/details/[:id]",function ($id = null){

    try{

        throw new Exception($id, 5);

    }catch (Exception $e){

        $e->toJson();

    }

});
```
```php
Router::get("/login/facebook",function (){

    echo "Login Facebook";

});
```
```php
Router::get("/login/github",function (){

    echo "Login Github";

});
```
```php
Router::get("/export/data-[:id].json/[:id]",function ($id = null,$params = null){

    echo json_encode([
       "id" => $id,
        "money" => $params
    ]);

});
```

```php
Router::notFound(function (){

   echo "Sayfa bulunamadı";

});
```
