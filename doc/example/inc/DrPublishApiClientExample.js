var DrPublishApiClientExample = {

    init:function () {
        $('textarea').keypress(function (e) {
            if (e.keyCode == 13) {
                DrPublishApiClientExample.submitForm(e.target);
                return false;
            }
        });

        var searchUis = $('#active-form fieldset');
        searchUis.each(
            function(index, element) {
                var label = $(this).find('legend').html();
                var name = $(this).find('form').attr('action');
                var menuElement = $('<div>' + label + '</div>');
                menuElement.attr('id', 'menu-button-' + name);
                menuElement.click( function() {
                    $('#active-form fieldset').hide();
                    $(element).show();
                    $('#form-pool div').removeClass('active');
                    $(this).addClass('active');
                    $('#api-response').html('');
                    $(element).find('input[type="text"]').first().focus();
                    var form = $(element).find('form');
                    if (form.attr('action').match(/search/)) {
                        var core = $(element).find('select.field-name').attr('data-core');
                        //if ( activatedElement.find('option').length == 1) {
                        DrPublishApiClientExample.submitForm(form.get(0));
                        DrPublishApiClientExample.fetchFields(core);
                        //}
                    }
                });
                $('#form-pool').append(menuElement);
            }
        );
        this.fetchFields('');
        $('#dp-url').change(function () {
            DrPublishApiClientExample.fetchFields()
        });
        $('#form-pool div').first().trigger('click');

    },

    submitForm:function (element) {
        var form = $(element).closest('form');
        $('#api-response').fadeOut(120, function () {
            $('#api-response').html('loading...');
            $('#api-response').fadeIn(120, function () {
                var action = form.attr('action');
                if (form.attr('id') == 'search-raw-query') {
                    var requestParameters = form.find('#raw-query').val() + '&readyRequest=1';
                } else {
                    var requestParameters = form.serialize();
                }
                var params = 'action=' + action + '&' + requestParameters;
                DrPublishApiClientExample.sendGetRequest(params);
            });
            return false;
        })
    },

    fetchFields:function (core) {
        var apiUrl = $('#dp-url').val();
        var coreName = core == '' ? 'pa' : core;
        if (apiUrl) {
            $.ajax(
                {
                    url:apiUrl + '/fields/core/' + coreName + '.json',
                    dataType:'json',
                    success:function (data) {
                        var fieldSelectInput = $('[data-core="' + core + '"]');
                        fieldSelectInput.find('option.dyn-field').remove();
                        var defaultField = fieldSelectInput.find('option.default-field').val();
                        var fields = [];
                        var fieldsAsObject = {};
                        $.each(data.items, function (index, element) {
                            if (element.name != 'original' && element.name != 'id' && element.name != defaultField) {
                                fields.push(element.name);
                                fieldsAsObject[element.name] = element;
                            }
                        });
                        fields.sort();
                        $.each(fields, function (index, element) {
                            if (element.name != 'original') {
                                fieldSelectInput.append('<option class="dyn-field" data-type="' + fieldsAsObject[element].type + '">' + element + '</option>');
                            }
                        });
                    }
                }
            )
        }
    },

    sendGetRequest:function (params) {
        params += '&publication=' + $('#dp-publication').val();
        params += '&dp-url=' + $('#dp-url').val();
        params += '&dp-url-internal=' + $('#dp-url-internal').val();
        params += '&dp-apikey=' + $('#dp-apikey').val();
        jQuery.get('web-client-test.php?' + params, function (data) {
            $('#api-response').fadeOut(120, function () {
                $('#api-response').html('no response');
                $('#api-response').html(data);
                $('#api-response').fadeIn();
                Prism.highlightAll();
            });
        });
    },

    showArticle:function(articleId) {
        $('#menu-button-article').trigger('click');
        $('#article-id').val(articleId);
        $('#search-article-submit').trigger('click');
    }

}

var Selectex = {
    init:function () {
        $('.selectex .plus').click(function () {
            Selectex.extend($(this));
        });
        $('.selectex .minus').click(function () {
            Selectex.remove($(this));
        });

        $('.selectex select.field-name').change(function (e) {
                var selectedOption = $(this).find('option:selected');
                $(this).parent().find('.type').html(selectedOption.attr('data-type'));
            }
        );

    },
    extend:function (selectexplus) {
        var selectex = selectexplus.closest('.selectex');
        var row = selectexplus.closest('.selrow');
        var newRow = row.clone(true);
        var len = selectex.find('.selrow').length;
        newRow.find('select, input').each(
            function (index, element) {
                var felement = $(element);
                var name = felement.attr('name');
                name = name.replace(/\[\d\]{1}/, '[' + (len + 1) + ']');
                felement.attr('name', name);
            }
        );
        newRow.find('input').val('');
        newRow.find('select').each(function () {
            this.selectedIndex = 0
        });
        newRow.removeClass('first');
        selectex.append(newRow);
        selectex.find('.minus').css({ 'display':'inline-block'});
        selectex.parent().find('.condition').fadeIn();
    },

    remove:function (selectexminus) {
        var selectex = selectexminus.closest('.selectex');
        var row = selectexminus.closest('.selrow');
        row.remove();
        var rows = selectex.find('.selrow');
        rows.each(function (rownr, row) {
            $(row).find('select, input').each(
                function (index, element) {
                    var felement = $(element);
                    var name = felement.attr('name');
                    name = name.replace(/\[\d\]{1}/, '[' + (rownr + 1) + ']');
                    felement.attr('name', name);
                }
            );
            if (rownr == 0) {
                $(row).addClass('first');
            }

        });
        if (rows.length == 1) {
            selectex.find('.minus').css({ 'display':'none'});
            selectex.parent().find('.condition').fadeOut();
        }
    }
}


$(document).ready(function () {
    DrPublishApiClientExample.init();
    Selectex.init();
});
