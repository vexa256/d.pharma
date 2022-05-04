/*window.addEventListener('DOMContentLoaded', (event) => {

    const StartPulse = () => {
        var PulseElement = $(".pulse_note");
        setInterval(function () {
            PulseElement.toggleClass("redMe");
        }, 1000);
    }

    const GetSoonExpiring = () => {

        fetch('http://d.pharma/api/GetSoonExpiringDrugs')
            .then((response) => response.json())

            .then((data) => {

                console.log(data);


                var NotifyEmptyHtml = `<a href="#"
                class="menu-link px-5">
                <span class="menu-text">No Soon Expiring Drugs</span>
                <span class="menu-badge">
                    <span
                        class="badge badge-light-danger badge-circle fw-bolder fs-4">0 </span>
                </span>
            </a>`;

                var NotifyHtml = ` <a href="/MgtSoonExpiring"
                class="menu-link px-5">
                <span class="menu-text">Soon Expiring Drugs</span>
                <span class="menu-badge">
                    <span
                        class="badge badge-light-danger badge-circle fw-bolder fs-4">${data.Expiring}  </span>
                </span>
            </a>`;



                if (data.Expiring <= 0) {

                    $('.DisplayNotify').append(NotifyEmptyHtml);



                } else {

                    $('.DisplayNotify').append(NotifyHtml);
                    StartPulse();
                }
            }) /**Close Fetch */


  /*  }

    /** Call GetSoonExpiring */
  /*  GetSoonExpiring();
/*




    const LowInStock = () => {


        fetch('http://d.pharma/api/LowInStock')
            .then((response) => response.json())

            .then((data) => {

                console.log(data);



                var NotifyEmptyHtml = `<a href="#"
                class="menu-link px-5">
                <span class="menu-text">No drugs below stock minimum</span>
                <span class="menu-badge">
                    <span
                        class="badge badge-light-danger badge-circle fw-bolder fs-4">0 </span>
                </span>
            </a>`;

                var NotifyHtml = ` <a href="/LowInStock"
                class="menu-link px-5">
                <span class="menu-text">Low in stock drugs</span>
                <span class="menu-badge">
                    <span
                        class="badge badge-light-danger badge-circle fw-bolder fs-4">${data.LockInStockDrugs}  </span>
                </span>
            </a>`;



                if (data.LockInStockDrugs <= 0) {

                    $('.DisplayNotify').append(NotifyEmptyHtml);



                } else {

                    $('.DisplayNotify').append(NotifyHtml);

                    StartPulse();
                }


            });

    }


    LowInStock();
});
*/