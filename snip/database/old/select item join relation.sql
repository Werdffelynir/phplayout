-- Categories and Subcategories by link
/*SELECT itch.* FROM item itp
LEFT JOIN relation r ON (r.parent = itp.id)
LEFT JOIN item itch ON (itch.id = r.child) 
WHERE  itp.link = 'php';*/

-- Get Subcategories by link
/*SELECT itch.* FROM item itp
LEFT JOIN relation r ON (r.parent = itp.id)
LEFT JOIN item itch ON (itch.id = r.child) 
WHERE  itp.link = 'php'  AND  itp.deep = 1;*/

