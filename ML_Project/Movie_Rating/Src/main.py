import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns

from cleaning import handle_missing, handle_duplicates, handle_outliers
from visualization import visualize



path = input("Enter CSV file path \n(Try 'Titanic' OR Enter Path if you have CSV) : ")
df = None
if path.lower() == "titanic":
    path = "./ML_Project/Movie_Rating/Src/Titanic.csv"
    df = pd.read_csv(path)
else:
    df = pd.read_csv(path)

print("\nFile uploaded successfully!")


  
def menu():
    print("\n===== DATA CLEANING MENU =====")
    print("0. Show All Data")
    print("1. Show dataset info")
    print("2. Search Data")
    print("3. Modify Data")
    print("4. Handle missing values")
    print("5. Handle duplicates")
    print("6. Handle outliers")
    print("7. Data visualization")
    print("8. Save Edited data")
    print("9. Exit")


def show_info(df):
    print("\nDataset Info : \n")
    print(df.info())
    print("\nMissing Values: \n")
    print(df.isna().sum()[df.isna().sum() > 0])
    
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
                print("Invalid numeric value!")
                return
        else:
            result = df[
                df[column_name]
                .astype(str)
                .str.contains(value, case=False, na=False)
            ]

        # -------- Result Check --------
        if result.empty:
            print("No matching records found!")
        else:
            print("\nMatching Records:")
            print(result)

    except ValueError:
        print("Invalid column selection!")

def edit_data(df):
    
    while True:
        print("\n===== EDIT / DELETE DATA MENU =====")
        print("1. Edit single cell")
        print("2. Edit entire row")
        print("3. Edit entire column")
        print("4. Delete single cell (set NaN)")
        print("5. Delete single row")
        print("6. Bulk delete rows")
        print("7. Delete entire column")
        print("8. Back")

        choice = input("Enter choice: ")

        # --------------------------------------------------
        # 1. EDIT SINGLE CELL
        # --------------------------------------------------
        if choice == '1':
            try:
                print("\nColumns:")
                for i, col in enumerate(df.columns, 1):
                    print(f"{i}. {col}")

                row = int(input("Row index (0-based): "))
                col = int(input("Column number: ")) - 1

                if row not in df.index or col not in range(len(df.columns)):
                    print("Invalid row or column!")
                    continue

                col_name = df.columns[col]
                print(f"Current value: {df.at[row, col_name]}")
                val = input("New value: ")

                if pd.api.types.is_numeric_dtype(df[col_name]):
                    val = float(val)

                df.at[row, col_name] = val
                print("Cell updated!")

            except:
                print("Invalid input!")

        # --------------------------------------------------
        # 2. EDIT ENTIRE ROW
        # --------------------------------------------------
        elif choice == '2':
            try:
                row = int(input("Row index (0-based): "))
                if row not in df.index:
                    print("Invalid row!")
                    continue

                print("\nCurrent Row:")
                print(df.loc[row])

                print("\nEnter new values (ENTER = keep old):")
                for col in df.columns:
                    old = df.at[row, col]
                    new = input(f"{col} [{old}]: ")

                    if new.strip() == "":
                        continue

                    if pd.api.types.is_numeric_dtype(df[col]):
                        new = float(new)

                    df.at[row, col] = new

                print("Row updated!")

            except:
                print("Invalid input!")

        # --------------------------------------------------
        # 3. EDIT ENTIRE COLUMN
        # --------------------------------------------------
        elif choice == '3':
            try:
                for i, col in enumerate(df.columns, 1):
                    print(f"{i}. {col}")

                col = int(input("Column number: ")) - 1
                if col not in range(len(df.columns)):
                    print("Invalid column!")
                    continue

                col_name = df.columns[col]
                val = input("New value for entire column: ")

                if pd.api.types.is_numeric_dtype(df[col_name]):
                    val = float(val)

                df[col_name] = val
                print("Column updated!")

            except:
                print("Invalid input!")

        # --------------------------------------------------
        # 4. DELETE SINGLE CELL
        # --------------------------------------------------
        elif choice == '4':
            try:
                row = int(input("Row index: "))
                col = int(input("Column number: ")) - 1

                if row not in df.index or col not in range(len(df.columns)):
                    print("Invalid row or column!")
                    continue

                df.at[row, df.columns[col]] = np.nan
                print("Cell cleared (NaN)!")

            except:
                print("Invalid input!")

        # --------------------------------------------------
        # 5. DELETE SINGLE ROW
        # --------------------------------------------------
        elif choice == '5':
            try:
                row = int(input("Row index to delete: "))
                if row not in df.index:
                    print("Invalid row!")
                    continue

                df.drop(index=row, inplace=True)
                df.reset_index(drop=True, inplace=True)
                print("Row deleted!")

            except:
                print("Invalid input!")

        # --------------------------------------------------
        # 6. BULK DELETE ROWS
        # --------------------------------------------------
        elif choice == '6':
            try:
                ch = input("Enter row indexes (e.g. 1,3,5): ")
                rows = [int(i.strip()) for i in ch.split(',')]

                invalid = [r for r in rows if r not in df.index]
                if invalid:
                    print("Invalid rows:", invalid)
                    continue

                confirm = input(f"Confirm delete {rows}? (y/n): ").lower()
                if confirm != 'y':
                    print("Cancelled!")
                    continue

                df.drop(index=rows, inplace=True)
                df.reset_index(drop=True, inplace=True)
                print("Rows deleted!")

            except:
                print("Invalid input!")

        # --------------------------------------------------
        # 7. DELETE ENTIRE COLUMN
        # --------------------------------------------------
        elif choice == '7':
            try:
                for i, col in enumerate(df.columns, 1):
                    print(f"{i}. {col}")

                col = int(input("Column number to delete: ")) - 1
                if col not in range(len(df.columns)):
                    print("Invalid column!")
                    continue

                df.drop(columns=[df.columns[col]], inplace=True)
                print("Column deleted!")

            except:
                print("Invalid input!")

        # --------------------------------------------------
        # BACK
        # --------------------------------------------------
        elif choice == '8':
            break

        else:
            print("Enter correct choice!")


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
        edit_data(df)
    elif choice == '4':
        handle_missing(df)
    elif choice == '5':
        handle_duplicates(df)
    elif choice == '6':
        df = handle_outliers(df)
    elif choice == '7':
        visualize(df)
    elif choice == '8':
        df.to_csv("./ML_Project/Movie_Rating/Data/cleaned.csv", index=False)
        print("\n=================================")
        print("!! Your CSV File is saved !!\nHave Fun !!")
        print("=================================\n")
    elif choice == '9':
        print("\n=================================")
        print("!! Thank You for your time !!")
        print("=================================\n")

        break
    else:
        print("\n=================================")
        print("Enter Choice Number Correctly!!")
        print("=================================\n")


  