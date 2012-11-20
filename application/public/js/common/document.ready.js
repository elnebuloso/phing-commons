$(document).ready(function() {
    $('#x-wave-front').pan({
        fps: 30,
        speed: 1.5,
        dir: 'left',
        depth: 70
    });
    
    $('#x-wave-front-shadow').pan({
        fps: 30,
        speed: 1.5,
        dir: 'left',
        depth: 70
    });
    
    $('#x-wave-back').pan({
        fps: 30,
        speed: 1,
        dir: 'left',
        depth: 30
    });
    
    $('#x-wave-back-shadow').pan({
        fps: 30,
        speed: 1,
        dir: 'left',
        depth: 30
    });
    
    $('#x-wave-front', '#x-wave-front-shadow', '#x-wave-back', '#x-wave-back-shadow').spRelSpeed(1);
});