CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = root@localhost
    SQL SECURITY DEFINER
VIEW view_groupby_idorder AS
    SELECT 
        orders.id AS idOrder,
        orders.status AS status
    FROM
        (((orders
        JOIN users ON ((orders.user_id = users.id)))
        JOIN product_order ON ((product_order.order_id = orders.id)))
        JOIN products ON ((product_order.product_id = products.id)))
    GROUP BY orders.id