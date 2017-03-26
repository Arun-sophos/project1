<!DOCTYPE html>

<html>

    <head>

<!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/css/styles.css" rel="stylesheet"/>

            <title>Web Scrapper</title>
        

        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <div>
                    <a href="/"><img alt="Scrapper" src="/img/logo.png"/></a>
                </div>
                
            </div>
            <div id="middle">
            <form action="searchdb.php" method="post" onsubmit="javascript:return validate('form');">
                <fieldset>
                <div class="form-group">
                    <input autocomplete="on" autofocus class="form-control" name="url" placeholder="Enter URL Here" type="text" required="required"/>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">
                        <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                        Search
                    </button>
                </div>
                </fieldset>
            </form>
            
            </div>

            <div id="bottom">
                Brought to you by the number <a href="http://espha.000webhostapp.com">Arun Siddharth</a>.
            </div>

        </div>

    </body>

</html>