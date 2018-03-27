var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // assets of the project
    .createSharedEntry('js/visit', [
        './assets/js/three.js',
        './assets/js/dat.gui.min.js',
        './assets/js/visit.js'
    ])
    .addStyleEntry('css/footer', './assets/css/footer.css')
    .addStyleEntry('css/login_page', './assets/css/login_page.css')
    .addStyleEntry('css/drop', './assets/css/drop.css')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
