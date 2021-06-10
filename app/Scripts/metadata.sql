SELECT it.id, t3.text indice, t1.text titulo, tc.text colecao, ty.name tipo, t2.text data, tag.name tags
from omeka_items it
         left join omeka_collections c on (it.collection_id = c.id)
         left join omeka_element_texts tc on (tc.record_id = c.id)
         left join omeka_element_texts t1 on (t1.record_id = it.id)
         left join omeka_element_texts t2 on (t2.record_id = it.id)
         left join omeka_element_texts t3 on (t3.record_id = it.id)
         left join omeka_item_types ty on (it.item_type_id = ty.id)
         left join (
    select r.record_id, group_concat(t.name) name
    from omeka_records_tags r
             join omeka_tags t on (r.tag_id = t.id)
    group by r.record_id
) tag on (tag.record_id = it.id)
where ((t1.element_id = 50) or (t1.element_id is null))
  and ((t2.element_id = 40) or (t2.element_id is null))
  and ((t3.element_id = 43) or (t3.element_id is null))
  and ((tc.element_id = 50)  or (tc.element_id is null))