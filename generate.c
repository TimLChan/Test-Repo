/*
Name: Nehal Patel
Class: CS 102
Date: October 30, 2016
Program: Assignment 8
Description: Print numbers in a pattern
*/

#include <stdio.h>
int main() {
    int choice;
    int input;

    printf("Enter your choice: ");
    scanf("%d", &choice);
    printf("Enter an integer: ");
    scanf("%d", &input);
    
    int multiple_index = 0;
    int multiple = 0;
    switch (choice) {
        case 1:
            // generate multiples of 2 till input
            while (multiple <= input) {
                printf("%d ", multiple);
                multiple_index = multiple_index + 1;
                multiple = 2 * multiple_index;
            }

            break;
        case 2:
            // generate multiples of 3 till input
            do {
                printf("%d ", multiple);
                multiple_index = multiple_index + 1;
                multiple = 3 * multiple_index;
            } while (multiple <= input);

            break;
        case 3: 
            // generate numbers other than multiples of 3 till input
            for (int i = 0; i <= input; i++) {
                if ((i % 3) > 0) {
                    printf("%d ", i);
                }
            }
            
            break;
        case 4:
            // generate numbers and break out of the loop when it encounters input/2
            for (int i = 0; i <= input; i++) {
                printf("%d ", i);

                if ((input / 2) == i) {
                    break;
                }
            }

            break;
        default:
            printf("Invalid Input");
    }

    printf("\n"); // courtesy newline
}
