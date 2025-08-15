<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Call</title>
    <script src="https://unpkg.com/@daily-co/daily-js"></script>
    <style>
        body { margin: 0; padding: 0; overflow: hidden; }
        #video-call { width: 100vw; height: 100vh; }
    </style>
</head>
<body>
    <div id="video-call"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const callFrame = window.DailyIframe.createFrame({
                iframeStyle: {
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    border: 'none'
                }
            });

            callFrame.join({ url: '{{ $roomUrl }}' });
        });
    </script>
</body>
</html>