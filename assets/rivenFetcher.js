// show suggestions to search results
$(document).on("keydown", '#rivenWeaponName', function() {
    searchTrigger($(this).val());
});

function searchTrigger(query) {
    let datalist = $("#itemsList"),
        maxItems = 5; // max number of suggestions
    // delete all suggestions
    datalist.html('');

    // check if query is not empty
    if (0 === query.length) return;

    // call only to get weapon list
    FetchData("https://api.warframestat.us/weapons/search/");
    /**
     *  Fetch data from api server given in parameter
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
    function appendOption(itemName, type = 'weapon') {
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
            // check if item name starts with query
            if (item['name'].toLowerCase().startsWith(query.toLowerCase()) === false) return;
            // check if item already exists in datalist
            if (itemExists(item['name']) === true) return;
            // check for maximum items in list
            if (datalist.children().length >= maxItems) return;

            appendOption(item['name'], item['type']);
        });
    }
}
