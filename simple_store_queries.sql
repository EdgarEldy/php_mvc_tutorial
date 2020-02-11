alter table tbl_order add constraint fk_customer_id
foreign key(fk_customer_id) references tbl_customer(customer_id);

alter table tbl_order drop foreign key fk_customer_id;

alter table tbl_order add constraint fk_product_id
foreign key(fk_product_id) references tbl_product(product_id);

alter table tbl_order drop foreign key fk_product_id;

alter table tbl_product add constraint fk_cat_id
foreign key(fk_cat_id) references tbl_category(cat_id);

alter table tbl_product drop foreign key fk_cat_id;

alter table tbl_user add constraint fk_profile_id
foreign key(fk_profile_id) references tbl_profile(profile_id);

alter table tbl_user drop foreign key fk_profile_id;