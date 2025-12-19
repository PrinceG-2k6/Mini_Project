import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns

def has_nan(df):
    return df.isna().any().any()
def is_mixed_dtypes(df):
    return len(set(df.dtypes.astype(str))) > 1

def has_all_nan_rows(df):
    return df.isna().all(axis=1).any()

def has_all_nan_columns(df):
    return df.isna().all(axis=0).any()


def menu1():
    print("\n===== HANDLIING MISSING VALUE =====")
    print("1. Show All Missing Column")
    print("2. Show All Missing Row")
    print("3. Fill Missing Values")
    print("4. Drop Missing Values")
    print("5. Back")

def menu2():
    print("\n===== Filling MISSING VALUE =====")
    print("1. Forward Fill")
    print("2. Backward Fill")
    print("3. Replace NaN")
    print("4. Back")

def handle_missing(df):
    
    if not has_nan(df):
        print("\n=================================")
        print("No missing values found in DataFrame!")
        print("=================================\n")
        return

    nan_columns_list = df.columns[df.isna().any()].tolist()

    print("\n===============")
    print("Missing values found in columns:")
    for i, col in enumerate(nan_columns_list, 1):
        print(f"{i}. {col}")

    while True:
        pd.set_option('display.max_rows', None)
        menu1()
        choice = input("Enter choice: ")

        # ---------- Show Missing Columns ----------
        if choice == '1':
            print(df[nan_columns_list])

        # ---------- Show Missing Rows ----------
        elif choice == '2':
            print(df[df.isna().any(axis=1)])

        # ---------- Fill Missing Values ----------
        elif choice == '3':

            while True:
                menu2()
                ch = input("Enter choice: ")

                # ===== FORWARD FILL =====
                if ch == '1':
                    print("1. Row-Wise")
                    print("2. Column-Wise")
                    c = input("Enter choice: ")

                    try:
                        if c == '1':
                            if is_mixed_dtypes(df):
                                raise TypeError(
                                    "Row-wise forward fill not allowed for mixed datatypes "
                                    "(e.g., Name → Price)."
                                )
                            if has_all_nan_rows(df):
                                raise ValueError("Some rows contain all NaN values.")

                            df.ffill(axis=1, inplace=True)
                            print("Forward fill applied row-wise!")

                        elif c == '2':
                            if has_all_nan_columns(df):
                                raise ValueError("Some columns contain all NaN values.")

                            df.ffill(axis=0, inplace=True)
                            print("Forward fill applied column-wise!")

                        else:
                            print("Invalid choice!")

                    except (ValueError, TypeError) as e:
                        print(f"Operation not possible: {e}")

                # ===== BACKWARD FILL =====
                elif ch == '2':
                    print("1. Row-Wise")
                    print("2. Column-Wise")
                    c = input("Enter choice: ")

                    try:
                        if c == '1':
                            if is_mixed_dtypes(df):
                                raise TypeError(
                                    "Row-wise backward fill not allowed for mixed datatypes "
                                    "(e.g., Name → Fare)."
                                )
                            if has_all_nan_rows(df):
                                raise ValueError("Some rows contain all NaN values.")

                            df.bfill(axis=1, inplace=True)
                            print("Backward fill applied row-wise!")

                        elif c == '2':
                            if has_all_nan_columns(df):
                                raise ValueError("Some columns contain all NaN values.")

                            df.bfill(axis=0, inplace=True)
                            print("Backward fill applied column-wise!")

                        else:
                            print("Invalid choice!")

                    except (ValueError, TypeError) as e:
                        print(f"Operation not possible: {e}")

                # ===== REPLACE NaN =====
                elif ch == '3':

                    if not has_nan(df):
                        print("No missing values left to replace!")
                        continue

                    print("1. Replace with single value (all columns)")
                    print("2. Replace column-wise")
                    rc = input("Enter choice: ")

                    if rc == '1':
                        val = input("Enter value to replace NaN: ")

                        try:
                            val = float(val)
                            if val.is_integer():
                                val = int(val)
                        except:
                            pass

                        df.fillna(val, inplace=True)
                        print("All NaN values replaced successfully!")

                    elif rc == '2':
                        for col in nan_columns_list:
                            if df[col].isna().any():
                                val = input(f"Enter value for {col}: ")

                                try:
                                    val = float(val)
                                    if val.is_integer():
                                        val = int(val)
                                except:
                                    pass

                                df[col].fillna(val, inplace=True)

                        print("Column-wise replacement completed!")

                    else:
                        print("Invalid choice!")

                # ===== BACK =====
                elif ch == '4':
                    break

                else:
                    print("Invalid choice!")

        # ---------- Drop Missing Values ----------
        elif choice == '4':

            if not has_nan(df):
                print("No missing values to drop!")
                continue

            print("1. Row-Wise")
            print("2. Column-Wise")
            c = input("Enter choice: ")

            if c == '1':
                df.dropna(axis=0, inplace=True)
                print("Rows with missing values dropped!")

            elif c == '2':
                df.dropna(axis=1, inplace=True)
                print("Columns with missing values dropped!")

            else:
                print("Invalid choice!")

        # ---------- Back ----------
        elif choice == '5':
            break

        else:
            print("Invalid choice!")


def print_duplicate_groups(df, group_cols):
    grouped = df.groupby(group_cols)

    found = False
    for key, group in grouped:
        if len(group) > 1:
            found = True
            print("\n==============================")
            print(f"Duplicate Group: {key}")
            print("==============================")
            print(group)

    if not found:
        print("No duplicate groups found!")


def remove_duplicates(df):
    
    columns = df.columns.tolist()

    while True:
        print("\n===== DUPLICATE CHECK (GROUP-WISE) =====")
        print("1. Duplicate by single column")
        print("2. Duplicate by multiple columns")
        print("3. Back")

        choice = input("Enter choice: ")

        # -------- Single column grouping --------
        if choice == '1':
            print("\nAvailable Columns:")
            for i, col in enumerate(columns, 1):
                print(f"{i}. {col}")

            try:
                col_no = int(input("Select column number: "))
                if col_no < 1 or col_no > len(columns):
                    raise ValueError

                col_name = columns[col_no - 1]

                print(f"\nGrouped duplicates for column: {col_name}")
                print_duplicate_groups(df, [col_name])

            except ValueError:
                print("Invalid column selection!")

        # -------- Multiple column grouping --------
        elif choice == '2':
            print("\nAvailable Columns:")
            for i, col in enumerate(columns, 1):
                print(f"{i}. {col}")

            print("\nEnter column numbers separated by comma (e.g. 1,3)")
            user_input = input("Enter choices: ")

            try:
                indices = [int(i.strip()) for i in user_input.split(',')]
                group_cols = [columns[i - 1] for i in indices]

                print(f"\nThis is Data row which have same value of : {group_cols}")
                print_duplicate_groups(df, group_cols)

            except:
                print("Invalid input!")

        # -------- Back --------
        elif choice == '3':
            break

        else:
            print("Enter correct choice!")


def handle_outliers(df,col):
    print(1)