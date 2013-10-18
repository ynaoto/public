//
//  ViewController.m
//  StopWatch
//
//  Created by Naoto Yoshioka on 2013/10/18.
//  Copyright (c) 2013年 Naoto Yoshioka. All rights reserved.
//

#import "ViewController.h"
@import AVFoundation;

@interface ViewController ()
@property (weak, nonatomic) IBOutlet UILabel *timeLabel;
@property (weak, nonatomic) IBOutlet UIButton *startStopButton;

@end

@implementation ViewController
{
    int tickCount;
    NSTimer *theTimer;
    AVAudioPlayer *pingSound;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.

    NSBundle *mainBundle = [NSBundle mainBundle];
    NSURL *url;
    
    url = [mainBundle URLForResource:@"Ping"
                       withExtension:@"aiff"];
    pingSound = [[AVAudioPlayer alloc] initWithContentsOfURL:url
                                                       error:nil];
    [pingSound prepareToPlay];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)tick:(NSTimer*)theTimer
{
    int m, s, ss;
    tickCount++;
    ss = tickCount % 100;
    s = (tickCount / 100) % 60;
    m = (tickCount / 6000) % 60;
    self.timeLabel.text = [NSString stringWithFormat:@"%02d:%02d.%02d", m, s, ss];
}

- (IBAction)startStop:(id)sender {
    if (theTimer) {
        [self.startStopButton setTitle:@"Start" forState:UIControlStateNormal];
        [theTimer invalidate];
        theTimer = nil;
    } else {
        [self.startStopButton setTitle:@"Stop" forState:UIControlStateNormal];
        theTimer = [NSTimer scheduledTimerWithTimeInterval:1/100
                                                    target:self
                                                  selector:@selector(tick:)
                                                  userInfo:nil
                                                   repeats:YES];
    }
    [pingSound play];
}

@end
