<script type="text/javascript">
  @if (isset($event))
    window.livewire.on('{{ $event }}' , params => {
      // console.log(`A post was added with the id of: ${params.slug}, ${params.rating}`);
      var ratingContainer = document.getElementById(params.slug);
  @else
      var ratingContainer = document.getElementById('{{ $slug }}');
  @endif

  // progressbar.js@1.0.0 version is used
  // Docs: http://progressbarjs.readthedocs.org/en/1.0.0/

  var bar = new ProgressBar.Circle(ratingContainer, {
    color: '#fff',
    // This has to be the same size as the maximum width to
    // prevent clipping
    strokeWidth: 15,
    trailWidth: 1,
    easing: 'easeInOut',
    duration: 2500,
    text: {
      autoStyleContainer: true
    },
    from: { color: '#9ae6b4', width: 2 },
    to: { color: '#68d391', width: 6 },
    // Set default step function for all animate calls
    step: function(state, circle) {
      circle.path.setAttribute('stroke', state.color);
      circle.path.setAttribute('stroke-width', state.width);

      var value = Math.round(circle.value() * 100);
      if (value === 0) {
        circle.setText('0%');
      } else {
        circle.setText(value+'%');
      }

    }
  });

  @if (!isset($event))
    bar.animate({{ $rating }} / 100 );

  @else
    bar.animate(params.rating / 100 );
    });
  @endif

</script>
