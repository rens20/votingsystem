<?php
// Function to check if the user has voted for a specific officer type
function hasVotedForOfficerType($userId, $officerType, $conn) {
    $sql_check_vote = "SELECT COUNT(*) FROM votes WHERE voter_id = :userId AND officer = :officerType";
    $stmt = $conn->prepare($sql_check_vote);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':officerType', $officerType);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0; // Return true if count is greater than 0 (user has voted), false otherwise
}

// Other functions can be added here if needed
?>