var plots = [];

function onLoad() {
    tg = new Timeplot.DefaultTimeGeometry({
        gridColor: "#000000",
        axisLabelsPlacement: "top"
    });
    vg = new Timeplot.DefaultValueGeometry({
        min: 0
    });
    es1 = new Timeplot.DefaultEventSource();
    ds1 = new Timeplot.ColumnSource(es1, 1);
    es2 = new Timeplot.DefaultEventSource();
    ds2 = new Timeplot.ColumnSource(es2, 1);
    es3 = new Timeplot.DefaultEventSource();
    ds3 = new Timeplot.ColumnSource(es3, 1);
    var pInfo0 = [
        Timeplot.createPlotInfo({
            id: "Jobs Printed",
            dataSource: ds1, timeGeometry: tg, valueGeometry: vg,
            fillColor: "#80A050", lineColor: "#000000",
            showValues: true
        }),
        Timeplot.createPlotInfo({
            id: "Jobs Errored",
            dataSource: ds2, timeGeometry: tg, valueGeometry: vg,
            fillColor: "#cc8080", lineColor: "#ff0000",
            showValues: true
        })
    ];
    var pInfo1 = [
        Timeplot.createPlotInfo({
            id: "Unique Users",
            dataSource: ds3, timeGeometry: tg, valueGeometry: vg,
            fillColor: "#8080F0", lineColor: "#000000",
            showValues: true
        }),
    ];
    plots[0] = Timeplot.create(document.getElementById('plot0'), pInfo0);
    plots[0].loadText('data1.py', ',', es1);
    plots[0].loadText('data2.py', ',', es2);
    plots[1] = Timeplot.create(document.getElementById('plot1'), pInfo1);
    plots[1].loadText('data3.py', ',', es3);
}

var resizeTimerID = null;
function onResize() {
    if (resizeTimerID == null) {
        resizeTimerID = window.setTimeout(function() {
            resizeTimerID = null;
            plot0.repaint();
            plot1.repaint();
        }, 100);
    }
}
