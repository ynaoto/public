//
//  ViewController.m
//  Mukade
//
//  Created by Naoto Yoshioka on 2013/09/29.
//  Copyright (c) 2013年 Naoto Yoshioka. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()
@property (weak, nonatomic) IBOutlet UIImageView *head;
@property (weak, nonatomic) IBOutlet UIImageView *ped;

@end

@implementation ViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)pan:(UIPanGestureRecognizer *)sender
{
    static CGPoint p0;
    CGPoint p = [sender locationInView:self.view];

    if (sender.state != UIGestureRecognizerStateChanged) {
        p0 = p;
        return;
    }

    CGPoint t = CGPointMake(p.x - p0.x, p.y - p0.y);
    CGAffineTransform transform = CGAffineTransformMakeRotation(-atan2f(t.x, t.y));

    CGFloat d = sqrt(t.x * t.x + t.y * t.y);
    for (CGFloat e = 0; e < d; e += 10) { // 10のとこを変えると、足の密度が変わる
        CGPoint pos = CGPointMake(p.x - e * t.x / d, p.y - e * t.y / d);
        UIImageView *view = [[UIImageView alloc] initWithFrame:self.ped.frame];
        view.image = self.ped.image;
        view.center = pos;
        view.transform = transform;
        [self.view addSubview:view];
        
        [UIView animateWithDuration:10 // この数字で前に描いた足が消えるまでの秒数が変わる
                         animations:^{
                             view.alpha = 0.0;
                         }
                         completion:^(BOOL finished) {
                             [view removeFromSuperview];
                         }];
    }
    
    self.head.center = p;
    self.head.transform = transform;
    [self.view bringSubviewToFront:self.head];

    p0 = p;
}

@end
