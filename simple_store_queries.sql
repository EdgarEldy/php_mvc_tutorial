alter table `order` add constraint fk_customer_id
foreign key(fk_customer_id) references customer(customer_id);

alter table `order` drop foreign key fk_customer_id;

alter table `order` add constraint fk_product_id
foreign key(fk_product_id) references product(product_id);

alter table `order` drop foreign key fk_product_id;

alter table product add constraint fk_cat_id
foreign key(fk_cat_id) references category(cat_id);

alter table product drop foreign key fk_cat_id;

alter table user add constraint fk_profile_id
foreign key(fk_profile_id) references profile(profile_id);

alter table user drop foreign key fk_profile_id;