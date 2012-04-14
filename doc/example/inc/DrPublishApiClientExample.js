var DrPublishApiClientExmample = {

    init: function() {
        $('textarea').keypress(function(e) {
            console.debug(e.keyCode);
            if (e.keyCode == 13) {
                DrPublishApiClientExmample.submitForm(e.target);
                return false;
            }
        } );
        $('fieldset').addClass('inactive');
        $('fieldset').first().removeClass('inactive');
        $('fieldset legend').click(function(e) {
            //$('fieldset').addClass('inactive');
                $(e.target).closest('fieldset').find('form').fadeIn(
                    function() {
                        $('#api-response').fadeOut(
                            function() {
                                $(e.target).parent().siblings().find('form').fadeOut();

                            }
                        );

                    }
                );
//            $('fieldset form').fadeOut(function() {
//            });
            console.debug($(e.target).parent());
            //$(e.target).closest('fieldset').removeClass('inactive', 1000);

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
          $('#api-response').fadeOut(120, function() {showData(data)});
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