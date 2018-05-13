# fix-router

```
Router::controller("/test/[:all]", new \App\www\controller\Test(),"app");
```
```
Router::get("/home/dashboard",function (){

    echo "hello world!";

});
```
```
Router::get("/news/details/[:id]",function ($id = null){

    try{

        throw new Exception($id, 5);

    }catch (Exception $e){

        $e->toJson();

    }

});
```
```
Router::get("/login/facebook",function (){

    echo "Login Facebook";

});
```
```
Router::get("/login/github",function (){

    echo "Login Github";

});
```
```
Router::get("/export/data-[:id].json/[:id]",function ($id = null,$params = null){

    echo json_encode([
       "id" => $id,
        "money" => $params
    ]);

});
```

```
Router::notFound(function (){

   echo "Sayfa bulunamadı";

});
```
