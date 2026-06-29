// show suggestions to search results
$(document).on("keydown", '.itemNameinput', function() {
    searchTrigger($(this).val());
});

const allAvailableItems = $('#searchItems').data('items').item;
let itemMap = {};
function searchTrigger(query) {
    let datalist = $("#itemsList"),
        maxItems = 5; // max number of suggestions
    // delete all suggestions
    datalist.html('');

    // check if query is not empty
    if (0 === query.length) return;

    let data = [];

    allAvailableItems.forEach(function(item) {
        if (maxItems <= data.length) return;

        let itemListItem = item.name.toLowerCase();
        if (itemListItem.includes(query.toLowerCase())) {
            data.push(item);
        }
    })
    fillTemplate(data);

    // fill template function with data
    function fillTemplate(data) {
        $(data).each(function () {
            let item = $(this)[0];

            itemMap[item.name] = item.slug;

            let option = `
            <option 
                value="${item.name}" 
                label="${item.tags.toString()}">
            </option>
        `;

            datalist.append(option);
        });
    }
}

// on submiting main nav search query replace page
// change to refresh content on watchlist
$(document).on("submit", "#searchItems", function(e){
    e.preventDefault();
    let
        form = $(this),
        search = form.find(".itemNameinput").val(),
        slug = itemMap[search];
    location.replace('/item/search_market/'+slug);
});
