# geoip2

> 基于workerman的HTTP协议写的ip查询功能<br />

## 安装

+ git clone https://github.com/timzzx/geoip2.git
+ cd geoip2
+ composer install
+ 自己加入GeoLite2-City.mmdb
+ php index.php
+ 浏览器访问http://127.0.0.1:2345/?ip=115.85.29.130
+ 返回结果：

```
{
    errno: 200,
    isoCode: "PH",
    country_name: "Philippines",
    country_name_zh: "菲律宾",
    mostSpecificSubdivisionname: "Metro Manila",
    mostSpecificSubdivisionisoCode: "00",
    city_name: "Las Pinas",
    city_name_zh: null,
    postal_code: "1612",
    latitude: 14.4506,
    longitude: 120.9828
}
```
