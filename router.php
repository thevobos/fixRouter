<?php



namespace Core\Router;

class Router
{

    const PATTERN =
        [
            "[:id]",
            "[:text]",
            "[:all]",
            "."
        ];

    const DATA =
        [
            "[:id]",
            "[:text]",
            "[:all]"
        ];

    const REPLACE =
        [
            "[0-9]*",
            "[a-zA-Z]*",
            "[a-zA-Z0-9]*",
            ".*\.*"
        ];

    const REGEX                 = "@^REGEX$@";
    const REGEX_DATA            = "|REGEX|U";

    const POST                  = "POST";
    const GET                   = "GET";
    const PUT                   = "PUT";
    const DELETE                = "DELETE";

    public static $writeRoute   = null;
    public static $writeUrl     = null;
    public static $getMethod    = null;
    public static $getRoute     = null;
    public static $getFilter    = null;



    /**
     * @param null $getUrl
     * @return mixed
     */
    public static function getReplacePattern($getUrl = null){

        return str_replace(self::PATTERN,self::REPLACE,$getUrl);

    }


    /**
     * @param null $getPattern
     * @return false|int
     */
    public static function getReturnPattern($getPattern = null){

        return str_replace(self::DATA,"(.*?)",$getPattern);

    }


    /**
     * @param null $getUrl
     * @param string $setMethod
     * @return mixed
     */
    public static function withReplaceUrl($getUrl = null, $setMethod = self::GET){

        $writeREGEX         =   str_replace("REGEX",self::getReplacePattern($getUrl),self::REGEX);
        $writeDATA          =   str_replace("REGEX",self::getReturnPattern($getUrl),self::REGEX_DATA);
                                preg_match_all($writeDATA,self::getRoute(),$export);

        $dataReturn         =   [$writeREGEX,$writeDATA,$setMethod,"DATA" => $export];
        self::$writeRoute[] =   $dataReturn;

        return $dataReturn;

    }

    /**
     * @return null
     */
    public static function getMethod(){

        self::$getMethod =  $_SERVER['REQUEST_METHOD'];
        return self::$getMethod;

    }

    /**
     * @return null
     */
    public static function getRoute(){

        self::$getRoute =  $_SERVER['REQUEST_URI'];
        return self::$getRoute;

    }

    /**
     * @param null $setRoute
     * @param string $setMethod
     * @return bool
     */
    public static function isMatch($setRoute = null, $setMethod = "GET"){

        return ( (self::getMethod() === $setMethod) &&  (preg_match($setRoute,self::getRoute())) ) ? true : false;

    }


    /**
     * @param array $Parameters
     * @return array
     */
    public static function setCallParameters(array $Parameters = []) {

        $setParameters = [];
        foreach ($Parameters as $getPar): $setParameters[] = $getPar[0]; endforeach;
        unset($setParameters[0]);
        return $setParameters;

    }


    /**
     * @param null $getRoute
     * @param callable $function
     */
    public static function get($getRoute = null, callable $function){

        self::isMatch(self::withReplaceUrl($getRoute,"GET")[0],"GET") ?
            call_user_func_array(
                $function,
                self::setCallParameters(self::withReplaceUrl($getRoute,"GET")["DATA"])
            )
            : false;
    }

    /**
     * @param null $getRoute
     * @param callable $function
     */
    public static function post($getRoute = null, callable $function){

        self::isMatch(self::withReplaceUrl($getRoute,"POST")[0],"POST") ?
            call_user_func_array(
                $function,
                self::setCallParameters(self::withReplaceUrl($getRoute,"POST")["DATA"])
            )
            : false;
    }


    /**
     * @param null $getRoute
     * @param callable $function
     */
    public static function delete($getRoute = null, callable $function){

        self::isMatch(self::withReplaceUrl($getRoute,"DELETE")[0],"DELETE") ?
            call_user_func_array(
                $function,
                self::setCallParameters(self::withReplaceUrl($getRoute,"DELETE")["DATA"])
            )
            : false;
    }

    /**
     * @param null $getRoute
     * @param callable $function
     */
    public static function put($getRoute = null, callable $function){

        self::isMatch(self::withReplaceUrl($getRoute,"PUT")[0],"PUT") ?
            call_user_func_array(
                $function,
                self::setCallParameters(self::withReplaceUrl($getRoute,"PUT")["DATA"])
            )
            : false;
    }

    /**
     * @param null $getRoute
     * @param callable $function
     */
    public static function head($getRoute = null, callable $function){

        self::isMatch(self::withReplaceUrl($getRoute,"HEAD")[0],"HEAD") ?
            call_user_func_array(
                $function,
                self::setCallParameters(self::withReplaceUrl($getRoute,"HEAD")["DATA"])
            )
            : false;
    }


    /**
     * @param null $getRoute
     * @param callable $function
     */
    public static function patch($getRoute = null, callable $function){

        self::isMatch(self::withReplaceUrl($getRoute,"PATCH")[0],"PATCH") ?
            call_user_func_array(
                $function,
                self::setCallParameters(self::withReplaceUrl($getRoute,"PATCH")["DATA"])
            )
            : false;
    }

    /**
     * @param null $getRoute
     * @param callable $function
     */
    public static function options($getRoute = null, callable $function){

        self::isMatch(self::withReplaceUrl($getRoute,"OPTIONS")[0],"OPTIONS") ?
            call_user_func_array(
                $function,
                self::setCallParameters(self::withReplaceUrl($getRoute,"OPTIONS")["DATA"])
            )
            : false;
    }

    /**
     * @param null $getRoute
     * @param null $getClass
     * @param null $getFunction
     */
    public static function controller($getRoute = null, $getClass = null, $getFunction = null){

        self::isMatch(self::withReplaceUrl($getRoute,"GET")[0],"GET") ?
            call_user_func_array(
                [$getClass,$getFunction],
                self::setCallParameters(self::withReplaceUrl($getRoute,"GET")["DATA"])
            )
            : false;
    }

    /**
     * @param callable $function
     */
    public static function notFound(callable $function){

        $count = 0;
        foreach (self::$writeRoute as $routs):
            if((preg_match($routs[0],self::getRoute()))) : $count +=1; endif;
        endforeach;

        if($count === 0) : $function(); endif;

    }



}
