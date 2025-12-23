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

def get_group_columns(df):
    columns = df.columns.tolist()
    print("\nAvailable Columns:")
    for i, col in enumerate(columns, 1):
        print(f"{i}. {col}")

    ch = input("Enter column numbers separated by comma (e.g. 1,3): ")
    indices = [int(i.strip()) for i in ch.split(',')]
    return [columns[i - 1] for i in indices]



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

def handle_duplicates(df):
    
    while True:
        print("\n===== DUPLICATE HANDLING (GROUP-WISE) =====")
        print("1. Show duplicate groups")
        print("2. Delete duplicate rows")
        print("3. Delete duplicate cell values (set NaN)")
        print("4. Back")

        choice = input("Enter choice: ")

        # ==================================================
        # 1. SHOW DUPLICATE GROUPS
        # ==================================================
        if choice == '1':
            try:
                group_cols = get_group_columns(df)
                print(f"\nGrouped duplicates based on: {group_cols}")
                print_duplicate_groups(df, group_cols)
            except:
                print("Invalid input!")

        # ==================================================
        # 2. DELETE DUPLICATE ROWS
        # ==================================================
        elif choice == '2':
            try:
                group_cols = get_group_columns(df)

                dup_rows = df.duplicated(subset=group_cols, keep='first')

                if not dup_rows.any():
                    print("No duplicate rows found!")
                    continue

                print("\nDuplicate Rows to be deleted:")
                print(df[dup_rows])

                confirm = input("Confirm delete duplicate rows? (y/n): ").lower()
                if confirm == 'y':
                    df.drop(index=df[dup_rows].index, inplace=True)
                    df.reset_index(drop=True, inplace=True)
                    print("Duplicate rows deleted successfully!")
                else:
                    print("Operation cancelled!")

            except:
                print("Invalid input!")

        # ==================================================
        # 3. DELETE DUPLICATE CELL VALUES (SET NaN)
        # ==================================================
        elif choice == '3':
            try:
                group_cols = get_group_columns(df)

                dup_rows = df.duplicated(subset=group_cols, keep='first')

                if not dup_rows.any():
                    print("No duplicate values found!")
                    continue

                print("\nDuplicate cell values to be cleared:")
                print(df.loc[dup_rows, group_cols])

                confirm = input("Confirm set duplicate values to NaN? (y/n): ").lower()
                if confirm == 'y':
                    for col in group_cols:
                        df.loc[dup_rows, col] = np.nan
                    print("Duplicate cell values set to NaN successfully!")
                else:
                    print("Operation cancelled!")

            except:
                print("Invalid input!")

        # ==================================================
        # BACK
        # ==================================================
        elif choice == '4':
            break

        else:
            print("Enter correct choice!")

def get_numeric_columns(df):
    return df.select_dtypes(include=['int64', 'float64']).columns.tolist()


def handle_outliers(df):
    
    numeric_cols = get_numeric_columns(df)

    if not numeric_cols:
        print("\nNo numeric columns available for outlier detection!")
        return

    while True:
        print("\n===== HANDLE OUTLIERS =====")
        
        print("\nOptions:")
        print("1. Show outliers")
        print("2. Remove outliers")
        print("3. Cap outliers (Winsorize)")
        print("4. Replace outliers with median")
        print("5. Visualize outliers (Boxplot)")
        print("6. Back")

        choice = input("Enter choice: ")

        if choice == '6':
            break
        else:
            try:
                print("Available Numeric Columns:")
                for i, col in enumerate(numeric_cols, 1):
                    print(f"{i}. {col}")
                col_no = int(input("Select column number: "))
                if col_no < 1 or col_no > len(numeric_cols):
                    raise ValueError

                col = numeric_cols[col_no - 1]

                # ----- IQR calculation -----
                Q1 = df[col].quantile(0.25)
                Q3 = df[col].quantile(0.75)
                IQR = Q3 - Q1

                lower = Q1 - 1.5 * IQR
                upper = Q3 + 1.5 * IQR

                outliers = df[(df[col] < lower) | (df[col] > upper)]

                # ----- Show outliers -----
                if choice == '1':
                    if outliers.empty:
                        print("No outliers detected!")
                    else:
                        print("\nDetected Outliers:")
                        print(outliers)

                # ----- Remove outliers -----
                elif choice == '2':
                    if outliers.empty:
                        print("No outliers to remove!")
                    else:
                        df.drop(outliers.index, inplace=True)
                        print("Outliers removed successfully!")

                # ----- Cap outliers -----
                elif choice == '3':
                    if outliers.empty:
                        print("No outliers to cap!")
                    else:
                        df[col] = df[col].clip(lower, upper)
                        print("Outliers capped successfully!")

                # ----- Replace with median -----
                elif choice == '4':
                    if outliers.empty:
                        print("No outliers to replace!")
                    else:
                        median = df[col].median()
                        df.loc[df[col] < lower, col] = median
                        df.loc[df[col] > upper, col] = median
                        print("Outliers replaced with median!")

                # ----- Boxplot -----
                elif choice == '5':
                    sns.boxplot(x=df[col])
                    plt.title(f"Outlier Visualization: {col}")
                    plt.show()

                else:
                    print("Enter correct choice!")

            except ValueError:
                print("Invalid column selection!")
