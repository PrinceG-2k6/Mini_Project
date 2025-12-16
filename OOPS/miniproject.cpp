#include <iostream>
#include <vector>
#include <string>
#include <iomanip>
#include <cstdlib>
#include <limits>
#include <algorithm> 

using namespace std;

class Product {
public:
    int id;
    string name;
    double price;
    int totalQuantity;
    int quantityInCart;

    Product(int id, const string &name, double price, int totalQuantity)
        : id(id), name(name), price(price), totalQuantity(totalQuantity), quantityInCart(0) {}

    void displayProduct() const {
        cout << setw(5) << id << setw(20) << name << setw(10) << fixed << setprecision(2) << price << setw(10) << totalQuantity << endl;
    }
};

class Supermarket {
private:
    vector<Product> cart;
    vector<Product> products;
    string username = "Admin", password = "admin";

    Product* findProductById(int productId);
    double calculateCartTotal();
    void displayProductDetails(const Product &product) const;

public:
    Supermarket();
    int check(string uname, string pass) {
        if (uname == username && pass == password)
            return 1;
        return 0;
    }

    void addProduct();
    void editProduct();
    void deleteProduct();
    void browseProducts();
    void addToCart();
    void removeFromCart(); 
    void viewCart();
    void checkout();
};

Supermarket::Supermarket() {
    products = {
        {2, "Bun", 15.00, 10},
        {3, "Banana", 5.00, 20},
        {4, "Cake", 25.00, 8},
        {5, "Chips", 15.00, 15},
        {6, "Soap", 50.00, 17},
        {7, "Sugar", 150.00, 12},
        {8, "Toothpaste", 80.00, 20},
        {9, "Juice", 22.00, 25},
        {10, "Pen", 6.00, 20},
        {11, "Ice-cream", 50.00, 20},
        {12, "Egg", 12.00, 52},
        {13, "Ball", 23.00, 9},
        {23, "Fruit", 34.00, 12},
        {34, "Chocolate", 345.00, 21}
    };
}

Product* Supermarket::findProductById(int productId) {
    for (auto &product : products)
        if (product.id == productId)
            return &product;
    return nullptr;
}

double Supermarket::calculateCartTotal() {
    double total = 0.0;
    for (const auto &item : cart) {
        total += item.price * item.quantityInCart;
    }
    return total;
}

void Supermarket::displayProductDetails(const Product &product) const {
    cout << "Product ID: " << product.id << endl;
    cout << "Name: " << product.name << endl;
    cout << "Price: " << fixed << setprecision(2) << product.price << endl;
    cout << "Available Quantity: " << product.totalQuantity << endl;
}

void Supermarket::addProduct() {
    int id, quantity;
    double price;
    string name;

    cout << "\nEnter Product ID: ";
    if (!(cin >> id)) {
        cout << "Invalid input for ID. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    if (findProductById(id)) {
        cout << "Product with ID " << id << " already exists." << endl;
        return;
    }

    cin.ignore(numeric_limits<streamsize>::max(), '\n');
    cout << "Enter Product Name: ";
    getline(cin, name);

    cout << "Enter Product Price: ";
    if (!(cin >> price) || price <= 0) {
        cout << "Invalid input for price. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    cout << "Enter Product Quantity: ";
    if (!(cin >> quantity) || quantity <= 0) {
        cout << "Invalid input for quantity. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    products.emplace_back(id, name, price, quantity);
    cout << "Product added successfully." << endl;
}

void Supermarket::editProduct() {
    int id, quantity;
    double price;
    string name;

    cout << "Enter Product ID to edit: ";
    if (!(cin >> id)) {
        cout << "Invalid input. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    Product *productToEdit = findProductById(id);
    if (!productToEdit) {
        cout << "Product with ID " << id << " not found." << endl;
        return;
    }

    cin.ignore(numeric_limits<streamsize>::max(), '\n');
    cout << "Enter Updated Product Name: ";
    getline(cin, name);

    cout << "Enter Updated Product Price: ";
    if (!(cin >> price) || price <= 0) {
        cout << "Invalid input for price. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    cout << "Enter Updated Product Quantity: ";
    if (!(cin >> quantity) || quantity < 0) { 
        cout << "Invalid input for quantity. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    productToEdit->name = name;
    productToEdit->price = price;
    productToEdit->totalQuantity = quantity;

    cout << "Product updated successfully." << endl;
}

void Supermarket::deleteProduct() {
    int id;
    cout << "Enter Product ID to delete: ";
    if (!(cin >> id)) {
        cout << "Invalid input. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    for (auto it = products.begin(); it != products.end(); ++it) {
        if (it->id == id) {
            products.erase(it);
            cout << "Product with ID " << id << " deleted successfully." << endl;
            return;
        }
    }
    cout << "Product with ID " << id << " not found." << endl;
}

void Supermarket::browseProducts() {
    cout << "\n\n---------------------------------------------------" << endl;
    cout << "ID    Name               Price         Quantity" << endl;
    cout << "---------------------------------------------------" << endl;
    for (const auto &product : products)
        product.displayProduct();
    cout << "---------------------------------------------------" << endl;
}

void Supermarket::addToCart() {
    int id, quantity;

    cout << "Enter Product ID to add to cart: ";
    if (!(cin >> id)) {
        cout << "Invalid input. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    Product *productToAdd = findProductById(id);
    if (!productToAdd) {
        cout << "Product not found." << endl;
        return;
    }

    cout << "Enter Quantity to add to cart: ";
    if (!(cin >> quantity)) {
        cout << "Invalid input. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    if (quantity <= 0 || quantity > productToAdd->totalQuantity) {
        cout << "Invalid quantity or not enough quantity available. Available: " << productToAdd->totalQuantity << endl;
        return;
    }

    bool foundInCart = false;
    for(auto &item : cart) {
        if(item.id == id) {
            item.quantityInCart += quantity;
            foundInCart = true;
            break;
        }
    }

    if (!foundInCart) {
        Product cartItem = *productToAdd;
        cartItem.quantityInCart = quantity;
        cart.push_back(cartItem);
    }

    cout << "Product added to cart." << endl;
    cout << "Current Cart Total: " << calculateCartTotal() << endl;
}

void Supermarket::removeFromCart() {
    int id, quantityToRemove;
    
    cout << "Enter Product ID to remove from cart: ";
    if (!(cin >> id)) {
        cout << "Invalid input. Returning to menu." << endl;
        cin.clear();
        cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }

    for (auto it = cart.begin(); it != cart.end(); ++it) {
        if (it->id == id) {
            cout << "Product found. Current quantity in cart: " << it->quantityInCart << endl;
            cout << "Enter Quantity to remove (or enter " << it->quantityInCart << " to remove all): ";
            
            if (!(cin >> quantityToRemove) || quantityToRemove <= 0) {
                cout << "Invalid quantity input. Returning to menu." << endl;
                cin.clear();
                cin.ignore(numeric_limits<streamsize>::max(), '\n');
                return;
            }

            if (quantityToRemove > it->quantityInCart) {
                cout << "Error: Cannot remove " << quantityToRemove << ". Only " << it->quantityInCart << " in cart." << endl;
                return;
            }

            if (quantityToRemove == it->quantityInCart) {
                it = cart.erase(it);
                cout << "Product completely removed from cart." << endl;
            } else {
                it->quantityInCart -= quantityToRemove;
                cout << quantityToRemove << " units of " << it->name << " removed from cart. Remaining: " << it->quantityInCart << endl;
            }
            cout << "Current Cart Total: " << calculateCartTotal() << endl;
            return;
        }
    }
    cout << "Product with ID " << id << " not found in cart." << endl;
}

void Supermarket::viewCart() {
    if (cart.empty()) {
        cout << "Your cart is empty." << endl;
        return;
    }

    cout << "\n---------------------------------------------------" << endl;
    cout << "ID    Name               Price         Quantity" << endl;
    cout << "---------------------------------------------------" << endl;
    for (const auto &product : cart)
        cout << setw(5) << product.id << setw(20) << product.name << setw(10) << fixed << setprecision(2) << product.price << setw(10) << product.quantityInCart << endl;
    cout << "---------------------------------------------------" << endl;
    cout << "Cart Total: " << calculateCartTotal() << endl;
    cout << "---------------------------------------------------" << endl;
}

void Supermarket::checkout() {
    if (cart.empty()) {
        cout << "Your cart is empty." << endl;
        return;
    }

    double finalTotal = 0.0;
    for (auto &item : cart) {
        Product *storeItem = findProductById(item.id);
        if (!storeItem || storeItem->totalQuantity < item.quantityInCart) {
            cout << "Error: Not enough stock for " << item.name << " (ID: " << item.id << "). Transaction aborted." << endl;
            return;
        }
        finalTotal += item.price * item.quantityInCart;
    }
    for (auto &item : cart) {
        Product *storeItem = findProductById(item.id);
        if (storeItem) {
            storeItem->totalQuantity -= item.quantityInCart;
        }
    }

    cout << "\n------------------- FINAL BILL --------------------" << endl;
    viewCart();
    cout << "---------------------------------------------------" << endl;
    cout << "Final Total Price: " << finalTotal << endl;
    cout << "Checkout completed. Thank you for shopping!" << endl;
    cout << "---------------------------------------------------" << endl;
    cart.clear();
}

int main() {
    Supermarket supermarket;
    string uname, pass;
    int option;
    cout << fixed << setprecision(2);

M:
    while (true) {
        cout << "\n\n-------------------------------------------" << endl;
        cout << "           Supermarket Billing System      " << endl;
        cout << "-------------------------------------------" << endl;
        cout << "1. Administration" << endl;
        cout << "2. Browse Products" << endl;
        cout << "3. Add to Cart" << endl;
        cout << "4. Remove from Cart" << endl;
        cout << "5. View Cart & Total" << endl; 
        cout << "6. Checkout" << endl;
        cout << "7. Exit" << endl;
        cout << "-------------------------------------------" << endl;
        cout << "Enter your choice: ";
        
        if (!(cin >> option)) {
            cout << "Invalid input. Please enter a number." << endl;
            cin.clear();
            cin.ignore(numeric_limits<streamsize>::max(), '\n');
            continue;
        }

        switch (option) {
            case 1:
                cout << "Enter user name: ";
                cin >> uname;
                cout << "Enter password: ";
                cin >> pass;
                if (supermarket.check(uname, pass)) {
                    int adminOpt;
                    while (true) {
                        cout << "\n1. Add Product\n2. Edit Product\n3. Delete Product\n4. Back to Main Menu\nEnter: ";
                        
                        if (!(cin >> adminOpt)) {
                            cout << "Invalid input. Returning to Main Menu." << endl;
                            cin.clear();
                            cin.ignore(numeric_limits<streamsize>::max(), '\n');
                            goto M;
                        }

                        if (adminOpt == 1) supermarket.addProduct();
                        else if (adminOpt == 2) supermarket.editProduct();
                        else if (adminOpt == 3) supermarket.deleteProduct();
                        else if (adminOpt == 4) goto M;
                        else cout << "Invalid admin option.\n";
                    }
                } else cout << "Invalid credentials.\n";
                break;
            case 2: supermarket.browseProducts(); break;
            case 3: supermarket.addToCart(); break;
            case 4: supermarket.removeFromCart(); break;
            case 5: supermarket.viewCart(); break;
            case 6: supermarket.checkout(); break;
            case 7: cout << "Goodbye!\n"; exit(0);
            default: cout << "Invalid option.\n";
        }
    }
    return 0;
}
