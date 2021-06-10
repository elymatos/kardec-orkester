alter table omeka_tags add `name_fr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL;

update omeka_tags set name_fr = 'Lettre' where id = 9;
update omeka_tags set name_fr = 'Communication' where id = 21;
update omeka_tags set name_fr = 'Copie de la lettre' where id = 11;
update omeka_tags set name_fr = 'Dialogue' where id = 22;
update omeka_tags set name_fr = 'Parole' where id = 19;
update omeka_tags set name_fr = 'Écriture' where id = 20;
update omeka_tags set name_fr = 'Évocation' where id = 13;
update omeka_tags set name_fr = 'Photographie' where id = 17;
update omeka_tags set name_fr = 'Fragment' where id = 14;
update omeka_tags set name_fr = 'Image' where id = 16;
update omeka_tags set name_fr = 'Lithographier' where id = 18;
update omeka_tags set name_fr = 'Noter' where id = 10;
update omeka_tags set name_fr = 'Prière' where id = 12;
update omeka_tags set name_fr = 'Psychographie' where id = 15;
update omeka_tags set name_fr = 'Brouillon de lettre' where id = 8;




'Lettre'
'La communication'
'Copie de la lettre'
'Dialogue'
'Parole'
'Écriture'
'Évocation'
'La photographie'
'Fragment'
'Image'
'Lithographier'
'Noter'
'Prière'
'Psychographie'
'Brouillon de lettre'
