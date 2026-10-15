create table recipes (
    id Int Auto_Increment Primary key,
    title varchar(120) not null,
    description text,
    created_at timestamp default current_timestamp
);

Insert into recipes (title, description)
values
('Ancho-Orange Chicken','Were amping up chicken breasts with a glaze of smoky ancho chile paste and fresh orange juice in this recipe. On the side, roasted carrots and lightly creamy, golden raisin-studded rice perfectly accent the sweetness of the glaze.' ),
('beef-medallions-mushroom-sauce', 'In this easy recipe, inspired by steak Diane (an American restaurant classic), were searing beef medallions, then using the fond in the pan to make a rich, bright mushroom sauce for spooning on top. Garlic mashed potatoes and sautéed kale make for delicious, simple sides.'),
('Broccoli & Basil Pesto Sandwhiches', 'These Italian focaccia sandwiches are layered with broccoli, three cheeses, and a savory basil, cashew, and pine nut pesto, then baked in the oven to meld all the bright, aromatic flavors. On the side, were serving a refreshing salad of romaine and seasonal clementine, dressed in a creamy dressing made with fresh clementine juice.' )