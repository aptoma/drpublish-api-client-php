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


$(document).ready(function() {
  DrPublishApiClientExmample.init();
});