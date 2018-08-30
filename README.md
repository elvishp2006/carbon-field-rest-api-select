# Carbon Field REST API Select

Disponibilize the ```rest_api_select``` field that fill options using the WP REST API.

## Installing

```
composer require elvishp2006/carbon-field-rest-api-select
```

## Methods

```set_endpoint```

```php
...
->set_endpoint( rest_url( 'wp/v2/posts' ) )
```

```set_endpoint_label_path``` | default: ```title.rendered```

```set_endpoint_value_path``` | default: ```id```

```set_endpoint_search_param``` | default: ```search```
