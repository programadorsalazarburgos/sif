@extends('cdm.layout')
@section('contenido')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h2>Usuarios Activos.</h2>
</body>

</html>
<script>
    (function(w, d, s, g, js, fs) {
        g = w.gapi || (w.gapi = {});
        g.analytics = {
            q: [],
            ready: function(f) {
                this.q.push(f);
            }
        };
        js = d.createElement(s);
        fs = d.getElementsByTagName(s)[0];
        js.src = 'https://apis.google.com/js/platform.js';
        fs.parentNode.insertBefore(js, fs);
        js.onload = function() {
            g.load('analytics');
        };
    }(window, document, 'script'));
</script>
<header>
    <div id="embed-api-auth-container"></div>
    <div id="view-selector-container"></div>
    <div id="view-name"></div>
    <div id="active-users-container"></div>
</header>
<!-- Include the ActiveUsers component script. -->
<script type="application/javascript" src="{{ asset('js/cdm/view-selector.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/cdm/active-users.js') }}"></script>
<script>
    // == NOTE ==
    // This code uses ES6 promises. If you want to use this code in a browser
    // that doesn't supporting promises natively, you'll have to include a polyfill.

    gapi.analytics.ready(function() {

        /**
         * Authorize the user immediately if the user has already granted access.
         * If no access has been created, render an authorize button inside the
         * element with the ID "embed-api-auth-container".
         */
        gapi.analytics.auth.authorize({
            container: 'embed-api-auth-container',
            clientid: '483927342134-44sb2n7qob3boaguj46q5525hgkval06.apps.googleusercontent.com'
        });


        /**
         * Create a new ActiveUsers instance to be rendered inside of an
         * element with the id "active-users-container" and poll for changes every
         * five seconds.
         */
        var activeUsers = new gapi.analytics.ext.ActiveUsers({
            container: 'active-users-container',
            pollingInterval: 5
        });


        /**
         * Add CSS animation to visually show the when users come and go.
         */
        activeUsers.once('success', function() {
            var element = this.container.firstChild;
            var timeout;

            this.on('change', function(data) {
                var element = this.container.firstChild;
                var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
                element.className += (' ' + animationClass);

                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    element.className =
                        element.className.replace(/ is-(increasing|decreasing)/g, '');
                }, 3000);
            });
        });

        /**
         * Create a new ViewSelector2 instance to be rendered inside of an
         * element with the id "view-selector-container".
         */
        var viewSelector = new gapi.analytics.ext.ViewSelector2({
                container: 'view-selector-container',
            })
            .execute();

        /**
         * Update the activeUsers component, the Chartjs charts, and the dashboard
         * title whenever the user changes the view.
         */
        viewSelector.on('viewChange', function(data) {
            var title = document.getElementById('view-name');
            title.textContent = data.property.name + ' (' + data.view.name + ')';

            // Start tracking active users for this view.
            activeUsers.set(data).execute();
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
@endsection