# Carbon Field REST API Select

Disponibilize the ```rest_api_select``` field that fill options using the WP REST API.

## Installing

```
composer require elvishp2006/carbon-field-rest-api-select
```

## Example

```php
Field::make( 'rest_api_select', 'id', __( 'Post' ) )
    ->set_endpoint_label_path( 'title.rendered' ) // Default: 'title.rendered'
    ->set_endpoint_value_path( 'id' )             // Default 'id'
    ->set_endpoint_search_param( 'search' )       // Default 'search'
    ->set_endpoint_params(
        [
            'per_page' => 20,
            'orderby'  => 'relevance',
        ]
    )
    ->set_endpoint( rest_url( 'wp/v2/posts' ) )
```
