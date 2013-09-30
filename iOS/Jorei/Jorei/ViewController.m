//
//  ViewController.m
//  Jorei
//
//  Created by Naoto Yoshioka on 2013/09/30.
//  Copyright (c) 2013年 Naoto Yoshioka. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()
@property (weak, nonatomic) IBOutlet UIImageView *target;

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

- (IBAction)jorei:(id)sender {
    [UIView animateWithDuration:3
                     animations:^{
                         self.target.alpha = 0;
                     }];
}

@end
