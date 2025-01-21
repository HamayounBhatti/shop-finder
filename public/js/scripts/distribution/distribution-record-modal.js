document.getElementById('submit-repaired-record').addEventListener('click', function () {
  var claimId = this.getAttribute('data-claimId');
  var claimName = this.getAttribute('data-claimName');
  document.getElementById('claimId').value = claimId;
  document.getElementById('claimName').value = claimName;
  var myModal = new bootstrap.Modal(document.getElementById('repairModal'));
  myModal.show();
 });
  