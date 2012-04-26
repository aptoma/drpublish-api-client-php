var DrPublishApiClientExmample = {

    init:function () {
        $('textarea').keypress(function (e) {
            if (e.keyCode == 13) {
                DrPublishApiClientExmample.submitForm(e.target);
                return false;
            }
        });

        $('fieldset legend').click(function (e) {
            var activatedElement = $(e.target).closest('fieldset');
            var deactivatedElement = $('#active-form fieldset');
            $('#active-form').prepend(activatedElement);
            $('#form-pool').prepend(deactivatedElement);
            activatedElement.find('input[type="text"]').first().focus();
            var form = activatedElement.find('form');
            if (form.attr('action').match(/search/)) {
                DrPublishApiClientExmample.submitForm(form.get(0));
            }
            $('#api-response').html('');
        });
        this.fetchFields('');
    },

    submitForm:function (element) {
        var form = $(element).closest('form');
        $('#api-response').fadeOut(120, function () {
            $('#api-response').html('loading...');
            $('#api-response').fadeIn(120, function () {
                var action = form.attr('action');
                var params = 'action=' + action + '&' + form.serialize();
                params += '&publication=' + $('#dp-publication').val();
                DrPublishApiClientExmample.sendGetRequest(params);
            });
            return false;
        })
    },

    fetchFields:function (core) {
        var apiUrl = $('#dp-url').val();
        if (apiUrl) {
            $.ajax(
                {
                    url:apiUrl + '/fields/core/' + core + '.json',
                    dataType:'json',
                    success:function (data) {
                        var fieldSelectInput = $('[data-core="' + core + '"]');
                        fieldSelectInput.append('<option>--filter field--</option>');
                        $.each(data.items, function (index, element) {
                            
                            fieldSelectInput.append('<option>' + element.name + '</option>');
                        })
                    }
                }
            )
        }


    },

    sendGetRequest:function (params) {
        params += '&dp-url=' + $('#dp-url').val();
        jQuery.get('web-client-test.php?' + params, function (data) {
            $('#api-response').fadeOut(120, function () {
                $('#api-response').html('no response');
                $('#api-response').html(data);
                $('#api-response').fadeIn();
            });
        });
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

    },
    extend:function (selectexplus) {
        var selectex = selectexplus.closest('.selectex');
        var row = selectexplus.closest('.row');
        var newRow = row.clone(true);
        var len = selectex.find('.row').length;
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
        selectex.append(newRow);
        selectex.find('.minus').css({ 'display':'inline-block'});
    },

    remove:function (selectexminus) {
        var selectex = selectexminus.closest('.selectex');
        var row = selectexminus.closest('.row');
        row.remove();
        var rows = selectex.find('.row');
        rows.each(function (rownr, row) {
            $(row).find('select, input').each(
                function (index, element) {
                    var felement = $(element);
                    var name = felement.attr('name');
                    name = name.replace(/\[\d\]{1}/, '[' + (rownr + 1) + ']');
                    felement.attr('name', name);
                }
            );
        });
        if (rows.length == 1) {
            selectex.find('.minus').css({ 'display':'none'});
        }
    }
}

$(document).ready(function () {
    DrPublishApiClientExmample.init();
    Selectex.init();
});