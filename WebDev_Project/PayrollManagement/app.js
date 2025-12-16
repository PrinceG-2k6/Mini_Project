$(document).ready(function() {
  let count = 0;

  $("#payrollForm").on("submit", function(e) {
    e.preventDefault();

    const name = $("#empName").val().trim();
    const rate = parseFloat($("#hourlyRate").val());
    const hours = parseFloat($("#hoursWorked").val());

    if (!name || rate < 0 || hours < 0) {
      alert("Please enter valid details.");
      return;
    }

    const gross = rate * hours;
    const tax = gross * 0.10;
    const net = gross - tax;

    count++;

    const row = `<tr>
      <td>${count}</td>
      <td>${name}</td>
      <td>${rate.toFixed(2)}</td>
      <td>${hours.toFixed(2)}</td>
      <td>${gross.toFixed(2)}</td>
      <td>${tax.toFixed(2)}</td>
      <td>${net.toFixed(2)}</td>
      <td><button class="delete-btn">Delete</button></td>
    </tr>`;

    $("#payrollTable tbody").append(row);

    // Reset form
    $("#payrollForm")[0].reset();
  });

  // Delete a row
  $("#payrollTable").on("click", ".delete-btn", function() {
    $(this).closest("tr").remove();
    // Optionally, adjust numbering
    count = 0;
    $("#payrollTable tbody tr").each(function() {
      count++;
      $(this).find("td:first").text(count);
    });
  });
});