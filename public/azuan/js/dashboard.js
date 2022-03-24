var d = new Date()
var arrMonth = ["January", 'February', "March", 'April', 'May', "June", "July", "Agustus", "September", "Oktober","November", "December"]

$(document).ready(function () {
    loadCard()
    loadChart()
});

function loadChart() {
    let date = d.getFullYear() + "-" + ('0' + (d.getMonth() + 1)).slice(-2)
    let endDate = new Date(d.getFullYear(), d.getMonth() + 1, 0).getDate();

    $.ajax({
        type: "POST",
        url: urlChart,
        data: {_token : token, startdate : date +"-01", enddate : date + "-" + ('0' + endDate).slice(-2)},
        success: function (response) {
            $("#date-chart").html(arrMonth[d.getMonth()] + " " + d.getFullYear());

            let label = []
            let data = []

            $.each(response, function (key, value) { 
                let date = value.date.split("-")
                label.push(date[2] + " " + arrMonth[date[1]-1])
                data.push(value.count)
            });

            var myLineChart = new Chart("rfp-chart", {
                type: 'line',
                data: {
                    labels: label,
                    datasets: [
                        {
                            label: "Total RFP",
                            borderColor: "#ee6f57",
                            backgroundColor: "#ee6f57",
                            data: data,
                            fill: false
						},
                    ],
                },
                options: {
                    responsive: true,
                    legend: { display: true },
                    maintainAspectRatio : false
                }
            });

            console.log(label);
            console.log(response);
        },
        error: function(err) {
            console.log(err.responseText);
        }
    });
}

function loadCard() {
    $.ajax({
        type: "POST",
        url: urlCard,
        data: {_token : token, periode : d.getFullYear() + "-" + ('0' + (d.getMonth() + 1)).slice(-2)},
        success: function (response) {
            $("#rfp-waiting").html(response.rfp.waiting);
            $("#rfp-onprogress").html(response.rfp.approveAdmin + response.rfp.approveManager);
            $("#rfp-transfer").html(response.rfp.transfer);
            $("#rfp-reject").html(response.rfp.reject);
        }
    });
}