// Auto dismissal for info notifications
$(function () {
  var alInfo = $("#alInfo");
  if (alInfo.length > 0) {
    alInfo.delay(3000).fadeOut(2000, function () {
      alInfo.hide();
    });
  }
});

function getOilChangeHtml(data) {
  // add 5000 miles
  var nextMileage = data.mileage + 5000;
  var nextDate = new Date(data.oil_change_dt);
  // add 6 months
  nextDate.setMonth(nextDate.getMonth()+6);

  return `<div class="inner"><h5>${data.myear} ${data.make} ${data.model}` +
    `</h5><h3>${nextMileage}</h3><h3>${nextDate.yyyymmdd()}</h3></div>`;
}

function getOilChangeHtmlAsEdit(data, idx) {

  return `<tr>`+ 
    `<td><input type="text" class="form-control" name="field[${idx}][make]" autocomplete="off" `+ 
    `spellcheck="false" autocapitalize="none" autocorrect="off" value="${data.make}"></td>`+
    `<td><input type="text" class="form-control" name="field[${idx}][model]" autocomplete="off" `+ 
    `spellcheck="false" autocapitalize="none" autocorrect="off" value="${data.model}"></td>`+
    `<td><input type="text" class="form-control" name="field[${idx}][myear]" autocomplete="off" `+ 
    `spellcheck="false" autocapitalize="none" autocorrect="off" value="${data.myear}"></td>`+
    `<td><input type="text" class="form-control" name="field[${idx}][color]" autocomplete="off" `+ 
    `spellcheck="false" autocapitalize="none" autocorrect="off" value="${data.color}"></td>`+
    `<td><input type="text" class="form-control" name="field[${idx}][mileage]" autocomplete="off" `+ 
    `spellcheck="false" autocapitalize="none" autocorrect="off" value="${data.mileage}"></td>`+
    `<td><input type="text" class="form-control" name="field[${idx}][oil_change_dt]" autocomplete="off" `+ 
    `spellcheck="false" autocapitalize="none" autocorrect="off" value="${data.oil_change_dt}"></td>`+
    `</tr>`;
}

$.getJSON("api.php?oilchangestats", function (data) {
  
  // idx zero is reserve for empty input for adding new rows
  $("#oil_change").append(`<tr>`+ 
  `<td><input type="text" class="form-control" name="field[0][make]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][model]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][myear]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][color]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][mileage]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][oil_change_dt]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `</tr>`);

  data.forEach(function (arrayItem, idx) {
    $("#oil_change").append(getOilChangeHtmlAsEdit(arrayItem, idx+1));
  });
  
});