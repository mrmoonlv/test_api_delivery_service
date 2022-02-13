# Setup
+ Run `docker-compose up -d`
+ Run ` docker exec -it 'api_order_app_php-fpm' composer install`
+ Run ` docker exec -it 'api_order_app_php-fpm' php artisan migrate`
+ Run ` docker exec -it 'api_order_app_php-fpm' php db:seed`

## Users Reference
| User Role | token    | Description                       |
| :-------- | :------- | :-------------------------------- |
| `customer`| `9c92n3i29ni3291i31093i92i3293` | ***Customer 1*** Can create orders / calculate shipping cost | 
| `customer`| `dfldkf034k3lk13045l24k240240k` | ***Customer 2*** Can create orders / calculate shipping cost |
| `customer`| `c34m34304cj304c93403940394304` | ***Customer 3*** Can create orders / calculate shipping cost |
| `courier` | `9c9c34m304i304i2l4024i02i3293` | ***Courier*** Can view orders |
| `sales_manager` | `9c9c34m304i304i2l4024i02i3293` | ***Manager*** Can view/create orders   |

## API Reference
#### Authorization
For each request need provide `token` field with value from Users Reference table in request headers


#### Shipping cost calculation
```http
  GET /api/calcPrice
```

###### Example call:
```
curl --location --request GET 'http://localhost/api/calcPrice' \
--header 'token: 9c92n3i29ni3291i31093i92i3293'
```

#### Getting a list of orders
```http
  GET /api/orders
```
###### Example call:
```
curl --location --request GET 'http://localhost/api/orders' \
--header 'token: 9c9c34m304i304i2l4024i02i3293'
```

#### Getting order information
```http
  GET /api/orders/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |
###### Example call:
```
curl --location --request GET 'http://localhost/api/orders/1' \
--header 'token: 9c9c34m304i304i2l4024i02i3293'
```

#### Order creation
```http
  POST /api/orders/create
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `items`   | `json` | **Required**. items in json format  |

items field Example call:
```a
[{"name":"CoCa Cola","qty":1,"unit_price":2},{"name":"Sprite","qty":2,"unit_price":1.8}]
```

###### Example call:
```
curl --location --request POST 'http://localhost/api/orders/create' \
--header 'token: c34m34304cj304c93403940394304' \
--form 'items="[{\"name\":\"Pica\",\"qty\":1,\"unit_price\":\"3.44\"},{\"name\":\"Sprite\",\"qty\":2,\"unit_price\":1.8}]"'
```

## Tests
```
docker exec -it 'api_order_app_php-fpm' php artisan test
```



