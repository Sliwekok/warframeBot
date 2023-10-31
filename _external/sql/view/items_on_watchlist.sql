/*
 * view shows all all items with platform name
 * used in ItemController -> watched
 */
create or alter view items_on_watchlist as
select i.id, i.login_id, i.name, i.price, i.wiki_url, i.image_url, p.name as platform_name
from item i
         inner join platform p on i.platform_id = p.id