// Preview and confirm the profile picture update
var previewAndConfirm = function (event) {
  var image = document.getElementById("output");
  var fileInput = event.target;

  // Check if a file is selected
  if (fileInput.files && fileInput.files[0]) {
      // Preview the selected image
      image.src = URL.createObjectURL(fileInput.files[0]);

      // change if websites going live
      // Ask for confirmation
      var confirmUpload = confirm("Do you want to save this profile picture?");
      if (confirmUpload) {
          // Submit the form if user confirms
          document.getElementById("profilePicForm").submit();
      } else {
          // Reset file input and preview if user cancels
          fileInput.value = ""; // Clear file input
          image.src = "<?php echo isset($_SESSION['Profile_Picture']) ? $_SESSION['Profile_Picture'] : '../image retrieverv2/userProfiles/default-user-profile.png'; ?>";
           // Reset to default or session image
      }
  }
};
