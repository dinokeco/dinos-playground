$(document).ready(function() {

  $("main#spapp > section").height($(document).height() - 60);

  var app = $.spapp({pageNotFound : 'error_404'}); // initialize

  // define routes
  app.route({
    view: 'view_1',
    onCreate: function() { $("#view_1").append($.now()+': Written on create<br/>'); },
    onReady: function() { $("#view_1").append($.now()+': Written when ready<br/>'); }
  });
  app.route({view: 'countries', load: 'countries.html' });
  app.route({view: 'charts', load: 'charts.html' });


  app.route({view: 'admin', load: 'admin.html' });


  // run app
  app.run();
});
