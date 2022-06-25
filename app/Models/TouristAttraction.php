<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristAttraction extends Model
{
    use HasFactory;
    protected $table = 'tourist_attraction';
    protected $appends = [
        'rating',
        'imageurl'
    ];

    public function getratingAttribute() {
        $fiveStar = $this->review_five_star;
        $fourStar = $this->review_four_star;
        $threeStar = $this->review_three_star;
        $twoStar = $this->review_two_star;
        $oneStar = $this->review_one_star;

        if ($fiveStar == null && $fourStar == null && $threeStar == null && $twoStar == null && $oneStar == null) {
            return '-';
        } 

        $totalRating = $fiveStar + $fourStar + $threeStar + $twoStar + $oneStar;
        $avgFive = 5 * $fiveStar;
        $avgFour = 4 * $fourStar;
        $avgThree = 3 * $threeStar;
        $avgTwo = 2 * $twoStar;
        $avgOne = 1 * $oneStar;

        $rating = ($avgFive + $avgFour + $avgThree + $avgTwo + $avgOne) / $totalRating;
        
        return (float) $rating;
    }
    
    public function getimageurlAttribute() {
        return (env('APP_ENV') == 'local') ? env('LOCAL_URL') . $this->image : env('PROD_URL') . $this->image;
    }

    public function openclose() {
        return $this->hasMany(OpenClose::class, 'id_tourist_attraction', 'id');
    }

    
}
