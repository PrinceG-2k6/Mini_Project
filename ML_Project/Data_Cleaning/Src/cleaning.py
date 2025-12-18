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

    print("===============")
    print("Missing values found in columns:")
    for i, col in enumerate(nan_columns_list, 1):
        print(f"{i}. {col}")

    while True:
        pd.set_option('display.max_rows', None)
        menu1()
        choice = input("Enter choice: ")

        # -------- Show Missing Columns --------
        if choice == '1':
            print(df[nan_columns_list])

        # -------- Show Missing Rows --------
        elif choice == '2':
            print(df[df.isna().any(axis=1)])

        # -------- Fill Missing Values --------
        elif choice == '3':

            while True:
                menu2()
                ch = input("Enter choice: ")

                # ---------- Forward Fill ----------
                if ch == '1':
                    print("1. Row-Wise")
                    print("2. Column-Wise")
                    c = input("Enter choice: ")

                    try:
                        if c == '1':
                            if df.isna().all(axis=1).any():
                                raise ValueError("Some rows contain all NaN values.")

                            df.ffill(axis=1, inplace=True)
                            print("Forward fill applied row-wise!")

                        elif c == '2':
                            if df.isna().all(axis=0).any():
                                raise ValueError("Some columns contain all NaN values.")

                            df.ffill(axis=0, inplace=True)
                            print("Forward fill applied column-wise!")

                        else:
                            print("Invalid choice!")

                    except ValueError as e:
                        print(f"Operation not possible: {e}")

                # ---------- Backward Fill ----------
                elif ch == '2':
                    print("1. Row-Wise")
                    print("2. Column-Wise")
                    c = input("Enter choice: ")

                    try:
                        if c == '1':
                            if df.isna().all(axis=1).any():
                                raise ValueError("Some rows contain all NaN values.")

                            df.bfill(axis=1, inplace=True)
                            print("Backward fill applied row-wise!")

                        elif c == '2':
                            if df.isna().all(axis=0).any():
                                raise ValueError("Some columns contain all NaN values.")

                            df.bfill(axis=0, inplace=True)
                            print("Backward fill applied column-wise!")

                        else:
                            print("Invalid choice!")

                    except ValueError as e:
                        print(f"Operation not possible: {e}")

                # ---------- Replace NaN ----------
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

                # ---------- Back ----------
                elif ch == '4':
                    break

                else:
                    print("Invalid choice!")

        # -------- Drop Missing Values --------
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

        # -------- Back --------
        elif choice == '5':
            break

        else:
            print("Invalid choice!")


    
def remove_duplicates(df):
    print(1)

def handle_outliers(df,col):
    print(1)