import Builder from './components/Builder'

document.addEventListener("DOMContentLoaded", DOMContentLoadedImport);

function DOMContentLoadedImport() {


    var appData = {
        name: "Team",
        version: "1.0.0",
        demoUrl: "https://pickplugins.com/demo/team/",
        reviewsUrl: "https://wordpress.org/support/plugin/team/reviews/#new-post/"
    }

    setTimeout(() => {

        var builderWrap = document.querySelector('#builder');

        // console.log(Builder);

        if (builderWrap != null) {
            wp.element.render(<Builder appData={appData} />, builderWrap)
        }
    }, 2000)



}




















