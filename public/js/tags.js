$(document).ready(function(){
    var elt = $('#txtTags');

    var tags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/api/find?keyword=%QUERY%',
            wildcard: '%QUERY%',
        }
    });

    tags.initialize();

    $('#txtTags').tagsinput({
        itemValue : 'id',
        itemText  : 'name',
        maxTags: 3,
        maxChars: 10,
        trimValue: true,
        allowDuplicates : false,
        freeInput: false,
        tagClass: function(item) {
            if(item.display)
                return 'label label-' + item.display;
            else
                return 'label label-default';

        },
        onTagExists: function(item, $tag) {
            $tag.hide().fadeIn();
        },
        typeaheadjs: [{
            hint: false,
            highlight: true
        },
            {
                name: 'tags',
                itemValue: 'id',
                displayKey: 'name',
                source: tags.ttAdapter(),
                templates: {
                    empty: [
                        '<ul class="list-group"><li class="list-group-item">Nothing found.</li></ul>'
                    ],
                    header: [
                        '<ul class="list-group">'
                    ],
                    suggestion: function (data) {
                        return '<li class="list-group-item">' + data.name + '</li>'
                    }
                }
            }]
    });

})