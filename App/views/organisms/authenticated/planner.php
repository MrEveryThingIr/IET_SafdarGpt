
<button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
  Primary 
</button>
<button class="bg-gray-500 text-white font-semibold py-2 px-4 rounded hover:bg-gray-600">
  Secondary
</button>
<button class="bg-transparent border border-blue-500 text-blue-500 font-semibold py-2 px-4 rounded hover:bg-blue-500 hover:text-white">
  Outline
</button>
<button class="bg-green-500 text-white font-semibold py-2 px-4 rounded-full hover:bg-green-600">
  Rounded Full
</button>
<button class="bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded cursor-not-allowed" disabled>
  Disabled
</button>
<button class="bg-purple-500 text-white font-semibold py-2 px-4 rounded flex items-center hover:bg-purple-600">
  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
  </svg>
  Icon Button
</button>
<button class="bg-red-500 text-white font-semibold py-1 px-3 rounded text-sm hover:bg-red-600">
  Small
</button>
<button class="bg-gradient-to-r from-pink-500 to-purple-500 text-white font-semibold py-2 px-4 rounded hover:from-pink-600 hover:to-purple-600">
  Gradient
</button>
<?php
// Persian month names
$persianMonths = [
    "Farvardin", "Ordibehesht", "Khordad", "Tir", "Mordad", "Shahrivar",
    "Mehr", "Aban", "Azar", "Dey", "Bahman", "Esfand"
];

// Number of days in each month for the year 1404
$daysInMonths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]; // Esfand has 29 days in 1404

// Start the calendar table
echo "<table class='w-full border-collapse border border-gray-300'>";
echo "<thead>";
echo "<tr>";
echo "<th class='p-3 bg-green-500 text-white font-bold border border-gray-300'>Day</th>";
foreach ($persianMonths as $month) {
    echo "<th class='p-3 bg-green-500 text-white font-bold border border-gray-300'>{$month}</th>";
}
echo "</tr>";
echo "</thead>";

echo "<tbody>";
// Loop through each day
for ($day = 1; $day <= 31; $day++) {
    echo "<tr>";
    echo "<td class='p-3 bg-blue-50 text-blue-600 font-bold border border-gray-300 text-center'>{$day}</td>";
    
    // Loop through each month
    for ($monthIndex = 0; $monthIndex < 12; $monthIndex++) {
        $daysInMonth = $daysInMonths[$monthIndex];
        if ($day <= $daysInMonth) {
            echo "<td data-day='{$day}' data-month='{$persianMonths[$monthIndex]}' class='trigger p-3 bg-yellow-100 text-blue-500 border border-gray-300 text-center hover:bg-yellow-200 cursor-pointer'>DAY_CONTENT</td>";
        } else {
            echo "<td class='p-3 bg-gray-100 border border-gray-300'></td>"; // Empty cell for months with fewer days
        }
    }
    
    echo "</tr>";
}
echo "</tbody>";

echo "</table>";
?>

<div id="optionsModal" class="modal">
    <ul id="optionsList">
        <!-- Options will be added here dynamically -->
    </ul>
</div>