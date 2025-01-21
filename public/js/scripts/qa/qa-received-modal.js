document.getElementById('received-claim').addEventListener('click', function () {
  var claimId = this.getAttribute('data-claimId');
  var claimName = this.getAttribute('data-claimName');
  document.getElementById('receivedId').value = claimId;
  document.getElementById('receivedName').value = claimName;
  var myModal = new bootstrap.Modal(document.getElementById('receivedClaimModal'));
  myModal.show();
 });
  