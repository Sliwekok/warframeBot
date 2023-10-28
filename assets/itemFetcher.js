// show suggestions to search results
$(".itemNameinput").on("keydown", function() {
    searchTrigger($(this).val());
});

function searchTrigger(query) {
    let datalist = $("#itemsList"),
        maxItems = 5; // max number of suggestions
    // delete all suggestions
    datalist.html('');

    // check if query is not empty
    if (0 === query.length) return;

    // call all 3 API methods to fill datalist, priority is: warframe, weapon, mod, item
    // mod and item are in the same group
    FetchData("https://api.warframestat.us/warframes/search/");
    FetchData("https://api.warframestat.us/weapons/search/");
    FetchData("https://api.warframestat.us/items/search/");
    /**
     *  Fetch data from api server given in parameter
     *  It need to fetch it from 3 different routes:
     *  ITEMS (items like relics), MODS, WARFRAMES (prime warframes parts), WEAPONS
     */
    async function FetchData(api) {
        // fetch data from api, fetch only items in english
        fetch(api + query, {
            headers:{
                "Accept-Language": "en",
            },
        })
            .then(res => { return res.json()})
            .then(data => fillTemplate(data));
    }


    // append option to datalist
    function appendOption(itemName, type) {
        let option = '<option label="'+type+'" value="'+itemName+'">'+itemName+'</option>';
        datalist.append(option);
    }

    // function to check if item exists in datalist
    function itemExists(item) {
        // set let to count failures
        let errors = 0;
        // go through each item in datalist
        datalist.children().each(function() {
            if ($(this).val().toLowerCase() === item.toLowerCase()) errors++;
        });

        // if more than 1 error - return true, because item already exists in datalist
        return errors > 0;
    }

    // fill template function with data
    function fillTemplate(data) {
        $(data).each(function() {
            // 0 means index with data
            let item = $(this)[0];
            // check if item is tradeble
            if (item['tradable'] === true) {
                // if max items are set, return function
                if (datalist.children().length >= maxItems) return;
                // check if item name starts with query
                if (item['name'].toLowerCase().startsWith(query) === false) return;
                // check if item already exists in datalist
                if (itemExists(item['name']) === true) return;

                appendOption(item['name'], item['type']);
            }
            // if item has components to build - check them
            else if (item.hasOwnProperty('components')){
                let isSetAvaible = false;
                // on each component run build
                $(item['components']).each(function() {
                    let part = $(this)[0],
                        partName = part['name'],
                        fullname = item['name'] + " " + partName;
                    if (part['tradable'] === false) return;
                    // if max items are set, return function
                    if (datalist.children().length >= maxItems) return;
                    // check if item name starts with query
                    if (fullname.toLowerCase().startsWith(query) === false) return;
                    // check if item already exists in datalist
                    if (itemExists(fullname) === true) return;
                    // check if compontent required is not an empty resource ingame
                    if ("Orokin Cell" === partName || "Nitain Extract" === partName) return;

                    isSetAvaible = true;
                    appendOption(fullname, item['type']);
                });

                // add set to allow buying all parts at once
                if (isSetAvaible) {
                    appendOption(item['name'] + " Set", item['type']);
                }
            }
        });
    }
}
