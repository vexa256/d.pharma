if ($('.ReloadTimer').length > 0) {

    if (window.performance) {
        console.info("window.performance works fine on this browser");
    }
    console.info(performance.navigation.type);
    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
        console.info("This page is reloaded");
        window.location.replace(GLOBAL_PATH + 'SelectExistingPatient');
    }
}
