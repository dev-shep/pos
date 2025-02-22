el diagrama entidad relacion esta en la base del proyecto denominado Diagrama Relación Entidad extendido

http://localhost:8000/api/register/client
{
    "nombre": "Juan Pérez",
    "correo": "juanperez@example.com",
    "contraseña": "123456"
}

http://localhost:8000/api/login/client
{
    "correo": "juanperez@example.com",
    "contraseña": "123456"
}

http://localhost:8000/api/register/vendor
{
    "nombre": "Carlos Ramírez",
    "correo": "carlos@example.com",
    "contraseña": "123456"
}


http://localhost:8000/api/login/vendor
{
    "correo": "karla@example.com",
    "contraseña": "123456"
}

http://localhost:8000/api/store
{
    "nombre": "Tienda de Ropa",
    "vendedor_id": 1
}
 obtener una tienda por su ID.
GET http://localhost:8000/api/store/1

enviar la petición PUT con los datos actualizados de la tienda.
http://localhost:8000/api/store/1

{
    "nombre": "Tienda de Electrónica",
    "vendedor_id": 1
}

// enviar la petición DELETE
 http://localhost:8000/api/store/1

crear producto
http://localhost:8000/api/product
{
    "nombre": "Camiseta",
    "precio": 199.99,
    "stock": 50,
    "tienda_id": 1
}

actualizar producto
PUT http://localhost:8000/api/product/1
{
    "nombre": "Camiseta Deportiva",
    "precio": 249.99,
    "stock": 40,
    "tienda_id": 1
}
enviar la petición DELETE
DELETE http://localhost:8000/api/product/1

crear carrito
POST http://localhost:8000/api/cart/1

actualizar carrito
PUT http://localhost:8000/api/cart/1/add-product
{
    "producto_id": 2,
    "cantidad": 3
}

eliminar producto del carrito
PUT http://localhost:8000/api/cart/1/remove-product
{
    "producto_id": 2
}
valida el stock y lo descuenta al finalizar la compra
POST http://localhost:8000/api/cart/1/checkout

 permita obtener el historial de compras de un cliente
GET http://localhost:8000/api/purchase-history/1

a manejar las tiendas y ventas
//GET http://localhost:8000/api/sales-history/1
