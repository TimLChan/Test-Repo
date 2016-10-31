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
            while (multiple <= input) {
                printf("%d\n", multiple);
                multiple_index = multiple_index + 1;
                multiple = 2 * multiple_index;
            }

            break;
        case 2:
            do {
                printf("%d\n", multiple);
                multiple_index = multiple_index + 1;
                multiple = 3 * multiple_index;
            } while (multiple <= input);

            break;
        case 3: 
            for (int i = 0; i <= input; i++) {
                if ((i % 3) > 0) {
                    printf("%d\n", i);
                }
            }
            
            break;
        case 4:
            for (int i = 0; i <= input; i++) {
                printf("%d\n", i);

                if ((input / 2) == i) {
                    break;
                }
            }

            break;
        default:
            printf("Invalid Input");
    }
}
