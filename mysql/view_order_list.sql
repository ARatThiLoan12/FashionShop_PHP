CREATE
    ALGORITHM = UNDEFINED 
    DEFINER = root@localhost
    SQL SECURITY DEFINER
VIEW view_order_list AS
    SELECT 
		orders.id AS idOrder,
		users.fullname AS fullname,
        users.phone AS phone,
        users.email AS email,
        users.id AS idUser,
        users.address AS address,
        products.id AS idProduct,
        products.name AS nameProduct,
        products.price AS price,
        products.saleprice AS saleprice,
        product_order.quantity AS quantity,
        orders.status AS status,
        orders.date_order AS dateOrder
    FROM
        (((orders
        JOIN users ON ((orders.user_id = users.id)))
        JOIN product_order ON ((product_order.order_id = orders.id)))
        JOIN products ON ((product_order.product_id = products.id)))
        
        