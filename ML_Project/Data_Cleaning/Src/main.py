import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns

from cleaning import handle_missing, remove_duplicates, handle_outliers
from visualization import visualize



path = input("Enter CSV file path \n(Try 'Titanic' OR Enter Path if you have CSV) : ")
df = None
if path.lower() == "titanic":
    path = "./ML_Project/Data_Cleaning/Src/Titanic.csv"
    df = pd.read_csv(path)
else:
    df = pd.read_csv(path)


print("\nFile uploaded successfully!")


  
def menu():
    print("\n===== DATA CLEANING MENU =====")
    print("0. Show All Data")
    print("1. Show dataset info")
    print("2. Search Data")
    print("3. Handle missing values")
    print("4. Remove duplicates")
    print("5. Handle outliers")
    print("6. Data visualization")
    print("7. Save cleaned data")
    print("8. Exit")


def show_info(df):
    print("\nDataset Info : \n")
    print(df.info())
    print("\nMissing Values: \n")
    print(df.isna().sum()[df.isna().sum() > 0])\
    
def search_info(df):
    columns = df.columns.tolist()
    pd.set_option('display.max_rows', None)
    # Show columns with numbers
    print("\nAvailable Columns:")
    for i, col in enumerate(columns, 1):
        print(f"{i}. {col}")

    try:
        col_choice = int(input("Select column number: "))

        if col_choice < 1 or col_choice > len(columns):
            raise ValueError

        column_name = columns[col_choice - 1]
        value = input(f"Enter value to search in '{column_name}': ")

        # -------- Search Logic --------
        if pd.api.types.is_numeric_dtype(df[column_name]):
            try:
                value = float(value)
                result = df[df[column_name] == value]
            except ValueError:
                print("❌ Invalid numeric value!")
                return
        else:
            result = df[
                df[column_name]
                .astype(str)
                .str.contains(value, case=False, na=False)
            ]

        # -------- Result Check --------
        if result.empty:
            print("❌ No matching records found!")
        else:
            print("\nMatching Records:")
            print(result)

    except ValueError:
        print("❌ Invalid column selection!")


while True:
    menu()
    choice = input("Enter choice: ")

    if choice == '0':
        pd.set_option('display.max_rows', None)
        print(df)
    elif choice == '1':
        show_info(df)
    elif choice == '2':
        search_info(df)
    elif choice == '3':
        handle_missing(df)
    elif choice == '4':
        remove_duplicates(df)
    elif choice == '5':
        col = input("Enter column for outliers: ")
        df = handle_outliers(df, col)
    elif choice == '6':
        visualize(df)
    elif choice == '7':
        df.to_csv("data/cleaned.csv", index=False)
    elif choice == '8':
        break
    else:
        print("\n=================================")
        print("Enter Choice Number Correctly!!")
        print("=================================\n")


  