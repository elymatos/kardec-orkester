insert into omeka_multilanguage_translations (record_id, element_id, record_type, locale_code, text, translation)
SELECT record_id, element_id, record_type, 'pt_BR', text, text
FROM omeka_multilanguage_translations
WHERE record_type = 'Item'
order by record_id, element_id

