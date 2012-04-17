var DrPublishApiClientExmample = {

    init: function() {
        $('textarea').keypress(function(e) {
            if (e.keyCode == 13) {
                DrPublishApiClientExmample.submitForm(e.target);
                return false;
            }
        } );

        //$('fieldset').first().addClass('active').find('form').show();
        $('fieldset legend').click(function(e) {
               var activateElement =  $(e.target).closest('fieldset');
               var deactiveElement =  $('#active-form fieldset');
               $('#active-form').prepend(activateElement);
               $('#form-pool').prepend(deactiveElement);
            $('#api-response').html('');

        });
    },

    submitForm: function(element) {
       var form = $(element).closest('form');
      // console.debug(form.serialize());
      //  return;
       $('#api-response').fadeOut(120, function() {
           $('#api-response').html('loading...');
           $('#api-response').fadeIn(120, function() { DrPublishApiClientExmample.requestApi(form) } );
           return false;
       })
    },

    requestApi: function(form) {
       var action = form.attr('action');
       var params = 'action='+ action + '&' + form.serialize();
       params += '&dp-url=' + $('#dp-url').val();
       params += '&publication=' + $('#dp-publication').val();
       jQuery.get('web-client-test.php?' + params, function(data) {
          $('#api-response').fadeOut(120, function() {$('#api-response').html('no response'); showData(data)});
       });
       var showData = function(data) {
          $('#api-response').html(data);
          $('#api-response').fadeIn();
       }
    }

}


var Selectex = {
    init: function() {
        $('.selectex .plus').click(function() {
            Selectex.extend($(this));
        });
        $('.selectex .minus').click(function() {
            Selectex.remove($(this));
        });

    },
    extend: function(selectexplus) {
        var selectex = selectexplus.closest('.selectex');
        var row = selectexplus.closest('.row');
        var newRow = row.clone(true);
        var len = selectex.find('.row').length;
        newRow.find('select, input').each(
            function(index, element) {
                var felement = $(element);
                var name = felement.attr('name');
                name = name.replace(/\[\d\]{1}/, '[' + (len+1) + ']');
                felement.attr('name', name);
            }
        );
        newRow.find('input').val('');
        newRow.find('select').each(function(){ this.selectedIndex = 0 });
        selectex.append(newRow);
        selectex.find('.minus').css({ 'display': 'inline-block'});
    },

    remove: function(selectexminus) {
        var selectex = selectexminus.closest('.selectex');
                var row = selectexminus.closest('.row');
                row.remove();
                var rows = selectex.find('.row');
                rows.each(function(rownr, row){
                    $(row).find('select, input').each(
                     function(index, element) {
                         var felement = $(element);
                         var name = felement.attr('name');
                         name = name.replace(/\[\d\]{1}/, '[' + (rownr+1) + ']');
                         felement.attr('name', name);
                     }
                 );
                }) ;
                if (rows.length == 1) {
                    selectex.find('.minus').css({ 'display': 'none'});
                }
    }
}


$(document).ready(function() {
  DrPublishApiClientExmample.init();
  Selectex.init();
});