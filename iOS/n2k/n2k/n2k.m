//
//  n2k.m
//  n2k
//
//  Created by Naoto Yoshioka on 2013/11/12.
//  Copyright (c) 2013年 Naoto Yoshioka. All rights reserved.
//

#import "n2k.h"

static NSString *join(NSArray *a)
{
    int n = a.count;
    NSString *s = @"";
    for (int i = 0; i < n; i++) {
        s = [s stringByAppendingString:a[i]];
    }
    return s;
}

static NSString *n2k_sub(int n, NSArray *moc)
{
    NSArray *nk1 = @[ @"", @"壱", @"弐", @"参", @"四", @"伍", @"六", @"七", @"八", @"九" ];
    NSArray *nk  = @[ @"", @""  , @"弐", @"参", @"四", @"伍", @"六", @"七", @"八", @"九" ];
    
    if (n < 10) {
        return nk1[n];
    }
    if (n < 100) {
        return join(@[nk[n / 10], @"拾", n2k_sub(n % 10, moc)]);
    }
    if (n < 1000) {
        return join(@[nk[n / 100], @"百", n2k_sub(n % 100, moc)]);
    }
    if (n < 10000) {
        return join(@[nk[n / 1000], @"千", n2k_sub(n % 1000, moc)]);
    }
    
    if (moc.count < 1) {
        NSLog(@"その数はでかすぎる");
        abort();
    }
    
    NSString *t = moc[0];
    NSRange range;
    range.location = 1;
    range.length = moc.count - 1;
    NSArray *moc2 = [moc subarrayWithRange:range];
    int u = n / 10000;
    return join(@[n2k_sub(u, moc2), u % 10000 != 0 ? t : @"", n2k_sub(n % 10000, moc)]);
}

NSString *n2k(int n)
{
    NSArray *moc = @[ @"萬", @"億", @"兆", @"京", @"垓" ];
    
    if (n == 0) {
        return @"零";
    }
    if (n < 0) {
        return join(@[@"マイナス", n2k_sub(-n, moc)]);
    }
    return n2k_sub(n, moc);
}