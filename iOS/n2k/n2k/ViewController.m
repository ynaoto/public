//
//  ViewController.m
//  n2k
//
//  Created by Naoto Yoshioka on 2013/11/12.
//  Copyright (c) 2013年 Naoto Yoshioka. All rights reserved.
//

#import "ViewController.h"
#import "n2k.h"

@interface ViewController ()
@property (weak, nonatomic) IBOutlet UITextField *number;
@property (weak, nonatomic) IBOutlet UILabel *result;

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

- (IBAction)convert:(id)sender {
    long long n = [self.number.text longLongValue];
    if (INT_MAX < n) {
        self.result.text = @"でかすぎ";
    } else {
        self.result.text = n2k(n);
    }
}

@end
